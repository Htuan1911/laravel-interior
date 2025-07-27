<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

   public function index()
{
    $compareIds = array_map('intval', session()->get('compare', []));

    $products = Product::with([
        'translations' => function ($q) {
            $q->where('language_code', 'vi');
        },
        'category.translations' => function ($q) {
            $q->where('language_code', 'vi');
        },
        'variants' => function ($q) {
            $q->where('status', 'active')->whereNull('deleted_at');
        }
    ])
    ->whereIn('id', $compareIds)
    ->where('status', 'active')
    ->whereNull('deleted_at')
    ->get();

    // Gợi ý AI nếu có sản phẩm
    $aiSuggestion = null;
    if ($products->isNotEmpty()) {
        $aiSuggestion = $this->gemini->compareProducts($products->toArray());

        // Xóa (ID: xx)
        $aiSuggestion = preg_replace('/\(ID:\s*\d+\)/', '', $aiSuggestion);

        // Xóa (Sản phẩm ID xx)
        $aiSuggestion = preg_replace('/\(Sản phẩm ID\s*\d+\)/', '', $aiSuggestion);
    }

    return view('client.compare.index', compact('products', 'aiSuggestion'));
}


    public function add($id)
    {
        $compare = session()->get('compare', []);

        if (!in_array($id, $compare)) {
            if (count($compare) >= 4) {
                return redirect()->back()->with('error', 'Bạn chỉ được so sánh tối đa 4 sản phẩm');
            }
            $compare[] = $id;
            session()->put('compare', $compare);
        }

        return redirect()->route('client.compare.index')->with('success', 'Đã thêm sản phẩm vào danh sách so sánh');
    }

    public function remove($id)
    {
        $compare = session()->get('compare', []);
        $compare = array_diff($compare, [$id]);
        session()->put('compare', $compare);

        return redirect()->route('client.compare.index')->with('success', 'Đã xóa sản phẩm khỏi danh sách so sánh');
    }

    public function clear()
    {
        session()->forget('compare');
        return redirect()->route('client.compare.index')->with('success', 'Đã xóa toàn bộ danh sách so sánh');
    }
}
