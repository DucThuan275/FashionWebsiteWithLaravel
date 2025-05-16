<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;  // Import Model Product
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $brandSlugs = (array) $request->input('brand', []); // Change to array
        $categorySlugs = (array) $request->input('category', []); // Change to array
        $viewType = $request->input('view', 'grid');
        $sortBy = $request->input('sort_by');

        $products = Product::query();

        if ($search) {
            $search = trim($search);
            $escapedSearch = addslashes($search);
            $products->whereRaw("BINARY name LIKE ?", ["%$escapedSearch%"]);
        }

        if ($priceMin) {
            $products->where('price_sale', '>=', $priceMin);
        }

        if ($priceMax) {
            $products->where('price_sale', '<=', $priceMax);
        }

        // Modified brand filter to handle multiple selections
        if (!empty($brandSlugs)) {
            $brandIds = Brand::whereIn('slug', $brandSlugs)->pluck('id');
            $products->whereIn('brand_id', $brandIds);
        }

        // Modified category filter to handle multiple selections
        if (!empty($categorySlugs)) {
            $categoryIds = Category::whereIn('slug', $categorySlugs)->pluck('id');
            $products->whereIn('category_id', $categoryIds);
        }

        // Sort logic remains the same
        if ($sortBy == 'price_asc') {
            $products->orderBy('price_buy', 'asc');
        } elseif ($sortBy == 'price_desc') {
            $products->orderBy('price_buy', 'desc');
        } elseif ($sortBy == 'newest') {
            $products->orderBy('created_at', 'desc');
        }

        $products = $products->paginate(4);
        $brands = Brand::all();
        $categories = Category::all();

        return view('frontend.product', compact(
            'products',
            'search',
            'brands',
            'categories',
            'viewType',
            'sortBy',
            'brandSlugs',
            'categorySlugs'
        ));
    }
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }
    // In ProductController.php
    public function searchNameProduct(Request $request)
    {
        $search = trim($request->input('search'));

        if (empty($search)) {
            return response()->json(['products' => []]);
        }
        $escapedSearch = addslashes($search);
        $products = Product::whereRaw("BINARY `name` LIKE ?", ["%$escapedSearch%"])
            ->select('id', 'name', 'price', 'slug')  // Select only necessary fields
            ->limit(10)  // Limit the results to 10 (or any other reasonable number)
            ->get();

        // Return products in JSON format
        return response()->json(['products' => $products]);
    }

    public function showSearchResults(Request $request)
    {
        $search = trim($request->input('search'));

        if (empty($search)) {
            return view('frontend.search-results', ['products' => [], 'search' => $search]);
        }

        $escapedSearch = addslashes($search);
        $products = Product::whereRaw("BINARY `name` LIKE ?", ["%$escapedSearch%"])
            ->get();

        // Pass the results to the view
        return view('frontend.search-results', ['products' => $products, 'search' => $search]);
    }
}
