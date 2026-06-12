@extends('layouts.app')
@section('title', 'Modifier ' . $product->name)
@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8">
    <h1 class="text-2xl font-bold mb-6">✏️ Modifier : {{ $product->name }}</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom du produit</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select name="category_id" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix (DA)</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix promo (DA)</label>
                <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouvelle image (optionnel)</label>
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" class="w-24 h-24 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ $product->is_active ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-gray-700">Produit actif</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                <label for="is_featured" class="text-sm text-gray-700">Produit vedette</label>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-pink-600 text-white px-8 py-2 rounded-lg hover:bg-pink-700 font-bold transition">
                Sauvegarder
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 text-gray-700">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection