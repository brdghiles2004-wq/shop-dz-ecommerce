@extends('layouts.app')
@section('title', 'Modifier ' . $product->name)

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8">

    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-pink-600">← Retour</a>
        <h1 class="text-2xl font-bold">✏️ Modifier : {{ $product->name }}</h1>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Nom --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nom du produit *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
        </div>

        {{-- Catégorie --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Catégorie *</label>
            <select name="category_id" class="w-full border border-gray-200 rounded-xl px-4 py-3">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Prix d'achat --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Prix d'achat (DA)</label>
            <input type="number" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" class="w-full border rounded-xl px-4 py-3">
        </div>

        {{-- Prix --}}
        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Prix vente</label>
                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded-xl px-4 py-3">
            </div>

            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Prix promo</label>
                <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full border rounded-xl px-4 py-3">
            </div>
        </div>

        {{-- Stock --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded-xl px-4 py-3">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded-xl px-4 py-3">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Image --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Image du produit</label>

            {{-- ✅ CLOUDINARY FIX --}}
            @if($product->image)
                <img src="{{ $product->image }}" class="w-24 h-24 object-cover rounded-lg mb-2">
            @endif

            <input type="file" name="image" accept="image/*"
                   class="w-full border rounded-xl px-4 py-3">

            <p class="text-xs text-gray-400 mt-1">Laisser vide pour garder l'image actuelle</p>
        </div>

        {{-- Checkboxes --}}
        <div class="flex gap-6 pt-2">

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                <span>Produit actif</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                <span>Vedette ⭐</span>
            </label>

        </div>

        {{-- Buttons --}}
        <div class="flex gap-3 pt-4 border-t">

            <button type="submit"
                    class="flex-1 bg-pink-600 text-white py-3 rounded-xl font-bold hover:bg-pink-700">
                💾 Sauvegarder
            </button>

            <a href="{{ route('admin.products.index') }}"
               class="px-6 py-3 border rounded-xl">
                Annuler
            </a>

        </div>

    </form>

</div>

@endsection