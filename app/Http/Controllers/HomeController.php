<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->latest()
            ->take(12)
            ->get();
        
        $categories = Category::where('is_active', true)->get();

        return view('home', compact('products', 'categories'));
    }

    public function shop(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->has('category') && $request->category) {
            $query->whereHas('categories', function ($q) {
                $q->where('slug', request('category'));
            });
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('shop', compact('products', 'categories'));
    }

    public function productDetails($id)
    {
        $product = Product::findOrFail($id);
        $reviews = $product->reviews()->where('is_approved', true)->latest()->paginate(5);
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $id)
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('category_id', $product->categories()->pluck('category_id'));
            })
            ->limit(4)
            ->get();

        return view('products.details', compact('product', 'reviews', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $search = $request->get('q');
        $products = Product::where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(12);

        return view('search-results', compact('products', 'search'));
    }
}
