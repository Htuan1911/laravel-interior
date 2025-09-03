<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductVariant;



class ProductController extends Controller
{
    // public function index()
    // {
    //     $products = Product::with([
    //         'translations' => function ($query) {
    //             $query->where('language_code', 'vi');
    //         },
    //         'category.translations' => function ($query) {
    //             $query->where('language_code', 'vi');
    //         },
    //         'variants' => function ($query) {
    //             $query->where('status', 'active');
    //         }
    //     ])
    //         ->where('status', 'active')
    //         ->whereNull('deleted_at')
    //         ->latest()
    //         ->get();


    //     return view('client.products.index', compact('products'));
    // }

    // đã lọc được danh mục 
    //     public function index(Request $request)
    // {
    //     $query = Product::with([
    //         'translations' => function ($q) {
    //             $q->where('language_code', 'vi');
    //         },
    //         'category.translations' => function ($q) {
    //             $q->where('language_code', 'vi');
    //         },
    //         'variants' => function ($q) {
    //             $q->where('status', 'active');
    //         }
    //     ])
    //         ->where('status', 'active')
    //         ->whereNull('deleted_at');

    //     // Nếu có category_id thì lọc theo
    //     if ($request->has('category_id') && $request->category_id) {
    //         $query->where('category_id', $request->category_id);
    //     }

    //     $products = $query->latest()->get();

    //     // Gửi thêm danh sách categories để đổ ra form filter
    //     $categories = Category::with(['translations' => function ($q) {
    //         $q->where('language_code', 'vi');
    //     }])->get();

    //     return view('client.products.index', compact('products', 'categories'));
    // }

    // kích thước  
    //     public function index(Request $request)
    // {

    //       $categories = Category::with(['translations' => function ($q) {
    //         $q->where('language_code', 'vi');
    //     }])->get();

    //     // Bắt đầu query sản phẩm
    //     $query = Product::with([
    //         'translations' => function ($q) {
    //             $q->where('language_code', 'vi');
    //         },
    //         'category.translations' => function ($q) {
    //             $q->where('language_code', 'vi');
    //         },
    //         'variants' => function ($q) {
    //             $q->where('status', 'active');
    //         }
    //     ])
    //     ->where('status', 'active')
    //     ->whereNull('deleted_at');

    //     // Lọc theo danh mục
    //     if ($request->filled('category_id')) {
    //         $query->where('category_id', $request->category_id);
    //     }

    //     // Lọc theo màu sắc (nhiều giá trị)
    //     if ($request->filled('color')) {
    //         $colors = $request->input('color');
    //         $colors = is_array($colors) ? $colors : [$colors];
    //         $query->whereHas('variants', function ($q) use ($colors) {
    //             $q->whereIn('color', $colors);
    //         });
    //     }

    //     // Lọc theo chất liệu (nhiều giá trị)
    //     if ($request->filled('material')) {
    //         $materials = $request->input('material');
    //         $materials = is_array($materials) ? $materials : [$materials];
    //         $query->whereHas('variants', function ($q) use ($materials) {
    //             $q->whereIn('material', $materials);
    //         });
    //     }

    //     // Lọc theo kích thước (nhiều giá trị)
    //     if ($request->filled('size')) {
    //         $sizes = $request->input('size');
    //         $sizes = is_array($sizes) ? $sizes : [$sizes];
    //         $query->whereHas('variants', function ($q) use ($sizes) {
    //             $q->whereIn('size', $sizes);
    //         });
    //     }

    //     // Lấy danh sách sản phẩm
    //     $products = $query->paginate(12);

    //     // Dữ liệu cho bộ lọc
    //     $colors = ProductVariant::select('color')->distinct()->pluck('color')->filter()->values();
    //     $materials = ProductVariant::select('material')->distinct()->pluck('material')->filter()->values();
    //     $sizes = ProductVariant::select('size')->distinct()->pluck('size')->filter()->values();

    //     return view('client.products.index', compact(
    //         'products',
    //         'colors',
    //         'materials',
    //         'sizes'
    //     ));
    // }


    public function index(Request $request)
    {
        //  dd($request->all());
        // Lấy danh sách danh mục có bản dịch tiếng Việt
        $categories = Category::with([
            'translations' => function ($q) {
                $q->where('language_code', 'vi');
            },
            'children.translations' => function ($q) {
                $q->where('language_code', 'vi');
            }
        ])
            ->whereNull('parent_id')
            ->get();

        // Query sản phẩm chính
        $query = Product::with([
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
            ->where('status', 'active')
            ->whereNull('deleted_at');
        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
            $categoryIds = Category::where('id', $categoryId)
                ->orWhere('parent_id', $categoryId)
                ->pluck('id');
            $query->whereIn('category_id', $categoryIds);
        }
        // Lọc theo tên sản phẩm
        if ($request->filled('s')) {
            $keyword = $request->s;
            $query->whereHas('translations', function ($q) use ($keyword) {
                $q->where('language_code', 'vi')
                    ->where('name', 'like', '%' . $keyword . '%');
            });
        }
        // Lọc theo trạng mầu
        if ($request->filled('color')) {
            $colors = (array) $request->input('color');
            $query->whereHas('variants', function ($q) use ($colors) {
                $q->whereIn('color', $colors)->where('status', 'active')->whereNull('deleted_at');
            });
        }
        // Lọc theo chất liệu
        if ($request->filled('material')) {
            $materials = (array) $request->input('material');
            $query->whereHas('variants', function ($q) use ($materials) {
                $q->whereIn('material', $materials)->where('status', 'active')->whereNull('deleted_at');
            });
        }
        // Lọc theo kích thước
        if ($request->filled('size')) {
            $sizes = (array) $request->input('size');
            $query->whereHas('variants', function ($q) use ($sizes) {
                $q->whereIn('size', $sizes)->where('status', 'active')->whereNull('deleted_at');
            });
        }

        // Lọc theo khoảng giá (price nằm trong bảng variants)
        if ($request->filled('price_min')) {
            $priceMin = $request->price_min;
            $query->whereHas('variants', function ($q) use ($priceMin) {
                $q->where('price', '>=', $priceMin)->where('status', 'active')->whereNull('deleted_at');
            });
        }

        if ($request->filled('price_max')) {
            $priceMax = $request->price_max;
            $query->whereHas('variants', function ($q) use ($priceMax) {
                $q->where('price', '<=', $priceMax)->where('status', 'active')->whereNull('deleted_at');
            });
        }
        // Xử lý sắp xếp
        if ($request->filled('sort')) {
            $sort = $request->input('sort');

            switch ($sort) {
                case 'name_asc':
                    $query->join('product_translations', 'products.id', '=', 'product_translations.product_id')
                        ->where('product_translations.language_code', 'vi')
                        ->orderBy('product_translations.name', 'asc');
                    break;

                case 'name_desc':
                    $query->join('product_translations', 'products.id', '=', 'product_translations.product_id')
                        ->where('product_translations.language_code', 'vi')
                        ->orderBy('product_translations.name', 'desc');
                    break;

                case 'price_asc':
                    $minPriceSubquery = DB::table('product_variants')
                        ->select('product_id', DB::raw('MIN(price) as min_price'))
                        ->where('status', 'active')
                        ->whereNull('deleted_at')
                        ->groupBy('product_id');

                    $query->leftJoinSub($minPriceSubquery, 'min_prices', function ($join) {
                        $join->on('products.id', '=', 'min_prices.product_id');
                    })
                        ->orderBy('min_prices.min_price', 'asc')
                        ->select('products.*');
                    break;

                case 'price_desc':
                    $maxPriceSubquery = DB::table('product_variants')
                        ->select('product_id', DB::raw('MAX(price) as max_price'))
                        ->where('status', 'active')
                        ->whereNull('deleted_at')
                        ->groupBy('product_id');

                    $query->leftJoinSub($maxPriceSubquery, 'max_prices', function ($join) {
                        $join->on('products.id', '=', 'max_prices.product_id');
                    })
                        ->orderBy('max_prices.max_price', 'desc')
                        ->select('products.*');
                    break;
            }

            $query->select('products.*'); // Đảm bảo kết quả trả về là model Product
        }


        // Lấy toàn bộ sản phẩm để tính số lượng theo material
        $allProducts = (clone $query)->get();

        // Sản phẩm phân trang để hiển thị
        $products = $query->paginate(12);

        // Lấy danh sách màu, chất liệu, kích thước để hiển thị filter (chỉ lấy các variant active)
        $colors = ProductVariant::where('status', 'active')->whereNull('deleted_at')->distinct()->pluck('color')->filter();
        $materials = ProductVariant::where('status', 'active')->whereNull('deleted_at')->distinct()->pluck('material')->filter();
        $sizes = ProductVariant::where('status', 'active')->whereNull('deleted_at')->distinct()->pluck('size')->filter();

        return view('client.products.index', compact(
            'products',
            'categories',
            'colors',
            'materials',
            'sizes',
            'allProducts' // truyền thêm để đếm
        ));
    }




    public function show($id)
    {
        $product = Product::with([
            'translations' => fn($q) => $q->where('language_code', 'vi'),
            'variants.reviews' => fn($q) => $q->where('is_visible', true)->with('user'),
            'category.translations' => fn($q) => $q->where('language_code', 'vi'),
        ])->findOrFail($id);

        // Lấy category_id từ request (nếu có) để giữ filter
        $categoryId = request('category_id') ?? $product->category_id;

        // related / newest như trước, có thể áp filter categoryId nếu cần
        $relatedProducts = Product::with([
            'translations' => fn($q) => $q->where('language_code', 'vi'),
            'variants',
        ])
            ->where('category_id', $categoryId)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(3)
            ->get();

        $newestProducts = Product::with([
            'translations' => fn($q) => $q->where('language_code', 'vi'),
            'variants',
        ])
            ->where('status', 'active')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->orderBy('created_at', 'desc')
            ->take(9)
            ->get();

        $allReviews = $product->variants->flatMap->reviews;
        $reviewCount = $allReviews->count();
        $averageRating = $reviewCount > 0 ? round($allReviews->avg('rating'), 1) : 0;

        // **Thêm: lấy categories (cha + children) để view sử dụng**
        $categories = Category::with([
            'translations' => fn($q) => $q->where('language_code', 'vi'),
            'children.translations' => fn($q) => $q->where('language_code', 'vi'),
        ])
            ->whereNull('parent_id')
            ->get();

        return view('client.products.show', compact(
            'product',
            'relatedProducts',
            'newestProducts',
            'reviewCount',
            'averageRating',
            'categories'
        ));
    }




    // ClientProductController.php
    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(12);

        return view('client.products.index', compact('products', 'category'));
    }

    public function filter(Request $request)
    {
        $languageCode = 'vi';

        // Khởi tạo query builder
        $query = DB::table('products')
            ->join('product_translations', function ($join) use ($languageCode) {
                $join->on('products.id', '=', 'product_translations.product_id')
                    ->where('product_translations.language_code', '=', $languageCode);
            })
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('category_translations', function ($join) use ($languageCode) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.language_code', '=', $languageCode);
            })
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->whereNull('products.deleted_at');

        // Lọc theo tên sản phẩm
        if ($request->filled('name')) {
            $query->where('product_translations.name', 'LIKE', '%' . $request->name . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('products.category_id', $request->category_id);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('products.status', $request->status);
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $query->whereRaw('EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = products.id AND pv.price >= ?)', [$request->min_price]);
        }

        if ($request->filled('max_price')) {
            $query->whereRaw('EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = products.id AND pv.price <= ?)', [$request->max_price]);
        }

        // Lọc theo màu sắc
        if ($request->filled('color')) {
            $query->whereRaw('EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = products.id AND pv.color = ?)', [$request->color]);
        }

        // Lọc theo chất liệu (từ product_variants)
        if ($request->filled('variant_material')) {
            $query->whereRaw('EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = products.id AND pv.material = ?)', [$request->variant_material]);
        }

        // Lọc theo kích thước
        if ($request->filled('size')) {
            $query->whereRaw('EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = products.id AND pv.size = ?)', [$request->size]);
        }

        // Lọc theo tồn kho
        if ($request->filled('in_stock')) {
            if ($request->in_stock == '1') {
                // Có tồn kho
                $query->whereRaw('EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = products.id AND pv.stock_quantity > 0)');
            } else {
                // Hết hàng
                $query->whereRaw('NOT EXISTS (SELECT 1 FROM product_variants pv WHERE pv.product_id = products.id AND pv.stock_quantity > 0)');
            }
        }

        // Lọc theo thời gian tạo
        if ($request->filled('created_from')) {
            $query->whereDate('products.created_at', '>=', $request->created_from);
        }

        if ($request->filled('created_to')) {
            $query->whereDate('products.created_at', '<=', $request->created_to);
        }

        // Lọc theo thời hạn bảo hành
        if ($request->filled('min_warranty')) {
            $query->where('products.warranty_months', '>=', $request->min_warranty);
        }

        if ($request->filled('max_warranty')) {
            $query->where('products.warranty_months', '<=', $request->max_warranty);
        }

        // Lọc theo chất liệu (từ product_translations)
        if ($request->filled('material')) {
            $query->where('product_translations.material', 'LIKE', '%' . $request->material . '%');
        }

        // Lọc theo phong cách
        if ($request->filled('style')) {
            $query->where('product_translations.style', 'LIKE', '%' . $request->style . '%');
        }

        // Select và group by (giống như function index)
        $products = $query->select(
            'products.id',
            'products.image as main_image',
            'product_translations.name',
            'product_translations.description',
            'product_translations.material',
            'product_translations.style',
            'products.dimensions',
            'products.warranty_months',
            'products.status',
            'category_translations.name as category_name',
            'products.created_at',
            'products.deleted_at',
            DB::raw('SUM(product_variants.stock_quantity) as total_quantity'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.price ORDER BY product_variants.price SEPARATOR ", ") as prices'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.color ORDER BY product_variants.color SEPARATOR ", ") as colors'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.material ORDER BY product_variants.material SEPARATOR ", ") as materials'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.size ORDER BY product_variants.size SEPARATOR ", ") as sizes'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.image ORDER BY product_variants.image SEPARATOR ", ") as variant_images')
        )
            ->groupBy(
                'products.id',
                'product_translations.name',
                'product_translations.description',
                'product_translations.material',
                'product_translations.style',
                'products.dimensions',
                'products.warranty_months',
                'products.status',
                'category_translations.name',
                'products.created_at',
                'products.image',
                'products.deleted_at'
            );

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        switch ($sortBy) {
            case 'name':
                $products->orderBy('product_translations.name', $sortOrder);
                break;
            case 'price':
                $products->orderByRaw("CAST(SUBSTRING_INDEX(GROUP_CONCAT(DISTINCT product_variants.price ORDER BY product_variants.price), ',', 1) AS DECIMAL(10,2)) $sortOrder");
                break;
            case 'created_at':
                $products->orderBy('products.created_at', $sortOrder);
                break;
            case 'category':
                $products->orderBy('category_translations.name', $sortOrder);
                break;
            case 'stock':
                $products->orderByRaw("SUM(product_variants.stock_quantity) $sortOrder");
                break;
            default:
                $products->orderBy('products.id', $sortOrder);
        }

        // Phân trang
        $perPage = $request->get('per_page', 15);
        $products = $products->paginate($perPage);

        // Nếu là AJAX request, trả về JSON
        if ($request->ajax()) {
            return response()->json([
                'products' => $products,
                'html' => view('admin.products.partials.product_list', compact('products'))->render()
            ]);
        }

        // Lấy danh sách categories cho dropdown filter
        $categories = DB::table('categories')
            ->join('category_translations', function ($join) use ($languageCode) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.language_code', '=', $languageCode);
            })
            ->whereNull('categories.deleted_at')
            ->select('categories.id', 'category_translations.name')
            ->orderBy('category_translations.name')
            ->get();

        // Lấy danh sách các giá trị unique cho dropdown filters
        $colors = DB::table('product_variants')
            ->whereNotNull('color')
            ->where('color', '!=', '')
            ->distinct()
            ->pluck('color')
            ->sort()
            ->values();

        $sizes = DB::table('product_variants')
            ->whereNotNull('size')
            ->where('size', '!=', '')
            ->distinct()
            ->pluck('size')
            ->sort()
            ->values();

        $variantMaterials = DB::table('product_variants')
            ->whereNotNull('material')
            ->where('material', '!=', '')
            ->distinct()
            ->pluck('material')
            ->sort()
            ->values();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'colors',
            'sizes',
            'variantMaterials'
        ));
    }
}
