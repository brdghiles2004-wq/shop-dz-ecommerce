@extends('layouts.app')
@section('title', 'Ajouter produit')
@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8">
    <div class="flex items-center gap-3 mb-8">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-pink-600">← Retour</a>
        <h1 class="text-2xl font-bold">➕ Ajouter un produit</h1>
    </div>

    

        {{-- Nom --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nom du produit *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Crème hydratante rose"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('name') border-red-400 @enderror">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Catégorie --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Catégorie *</label>
            <select name="category_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                <option value="">-- Choisir --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Prix --}}
        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Prix (DA) *</label>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" placeholder="1500"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('price') border-red-400 @enderror">
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Prix promo (DA)</label>
                <input type="number" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0" placeholder="Optionnel"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            </div>
        </div>

        {{-- Stock --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Stock *</label>
            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3" placeholder="Description du produit..."
                      class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">{{ old('description') }}</textarea>
        </div>

        {{-- Image --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Image du produit</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-50 file:text-pink-700 file:font-semibold hover:file:bg-pink-100">
        </div>

        {{-- Checkboxes --}}
        <div class="flex gap-6 pt-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked
                       class="w-4 h-4 accent-pink-600">
                <span class="text-sm text-gray-700 font-medium">Produit actif</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_featured" value="1"
                       class="w-4 h-4 accent-pink-600">
                <span class="text-sm text-gray-700 font-medium">Produit vedette ⭐</span>
            </label>
        </div>

        {{-- Boutons --}}
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit"
                    class="flex-1 bg-pink-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-pink-700 transition">
                ✅ Enregistrer le produit
            </button>
            <a href="{{ route('admin.products.index') }}"
               class="px-6 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 text-gray-600 font-medium transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection