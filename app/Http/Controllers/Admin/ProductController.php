<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'cost_price'  => 'required|numeric|min:0',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data['slug']        = Str::slug($request->name);
        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        // 🟢 UPLOAD TO CLOUDINARY
        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'shop-dz-products'
                ]
            );

            $data['image'] = $uploaded->getSecurePath();
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'cost_price'  => 'required|numeric|min:0',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data['is_active']   = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        // 🟢 UPDATE IMAGE ON CLOUDINARY
        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                [
                    'folder' => 'shop-dz-products'
                ]
            );

            $data['image'] = $uploaded->getSecurePath();
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        // ⚠️ Cloudinary: image deletion optional (we skip for simplicity)
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé.');
    }
}