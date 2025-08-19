<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\ProductVariant;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from') ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = $request->input('to') ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $completedStatuses = ['paid', 'shipped', 'completed'];
        $pendingStatuses = ['pending', 'cancelled'];

        // Tổng doanh thu theo trạng thái thanh toán
        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->whereIn('status', $completedStatuses)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalRevenue = $dailyRevenue->sum('total');
        $labels = $dailyRevenue->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d/m/Y'));

        // Tổng đơn hàng đã hoàn thành
        $totalOrders = Order::whereIn('status', $completedStatuses)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->count();

        // Tổng đơn hàng chưa hoàn thành
        $pendingOrders = Order::whereIn('status', $pendingStatuses)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->count();

        // Tổng sản phẩm tồn kho
        $totalStock = ProductVariant::sum('stock_quantity');

        // Top 5 sản phẩm bán chạy
        $topSelling = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('product_variants', 'order_items.variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('product_translations', function ($join) {
                $join->on('product_translations.product_id', '=', 'products.id')
                     ->where('product_translations.language_code', '=', 'vi');
            })
            ->whereIn('orders.status', $completedStatuses)
            ->select(
                'product_translations.name as product_name',
                'product_variants.name as variant_name',
                'product_variants.sku',
                'product_variants.image as variant_image',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy(
                'product_translations.name',
                'product_variants.name',
                'product_variants.sku',
                'product_variants.image'
            )
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Top 5 sản phẩm tồn kho cao nhưng bán ít
        $lowSoldHighStock = DB::table('product_variants')
            ->leftJoin('order_items', 'order_items.variant_id', '=', 'product_variants.id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('product_translations', function ($join) {
                $join->on('product_translations.product_id', '=', 'products.id')
                     ->where('product_translations.language_code', '=', 'vi');
            })
            ->where(function ($query) use ($completedStatuses) {
                $query->whereNull('orders.status')
                      ->orWhereIn('orders.status', $completedStatuses);
            })
            ->select(
                'product_translations.name as product_name',
                'product_variants.name as variant_name',
                'product_variants.sku',
                'product_variants.image as variant_image',
                'product_variants.stock_quantity as stock',
                DB::raw('COALESCE(SUM(CASE WHEN orders.status IN ("paid", "shipped", "completed") THEN order_items.quantity ELSE 0 END), 0) as total_sold')
            )
            ->groupBy(
                'product_translations.name',
                'product_variants.name',
                'product_variants.sku',
                'product_variants.stock_quantity',
                'product_variants.image'
            )
            ->orderByDesc('stock')
            ->orderBy('total_sold')
            ->limit(5)
            ->get();

        // Top sản phẩm được yêu thích
        $mostWished = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->join('product_translations', function ($join) {
                $join->on('product_translations.product_id', '=', 'products.id')
                     ->where('product_translations.language_code', '=', 'vi');
            })
            ->select(
                'product_translations.name as product_name',
                DB::raw('COUNT(*) as wishlist_count')
            )
            ->groupBy('product_translations.name')
            ->orderByDesc('wishlist_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'dailyRevenue',
            'labels',
            'from',
            'to',
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'totalStock',
            'topSelling',
            'lowSoldHighStock',
            'mostWished'
        ));
    }
}
