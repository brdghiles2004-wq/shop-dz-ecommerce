<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->latest()->take(8)->get();

        $categories = Category::withCount('products')->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}