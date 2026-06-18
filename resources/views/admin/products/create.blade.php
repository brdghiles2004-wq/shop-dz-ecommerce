@extends('layouts.app')
@section('title', 'Ajouter produit')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8">

    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-pink-600">← Retour</a>
        <h1 class="text-2xl font-bold">➕ Ajouter un produit</h1>
    </div>

    <form action="{{ route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-5">

        @csrf

        {{-- Nom --}}
        <input type="text" name="name" placeholder="Nom du produit"
               value="{{ old('name') }}"
               class="w-full border rounded-xl px-4 py-3">

        {{-- Catégorie --}}
        <select name="category_id" class="w-full border rounded-xl px-4 py-3">
            <option value="">-- Choisir --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        {{-- Prix --}}
        <input type="number" name="cost_price" placeholder="Prix d'achat"
               class="w-full border rounded-xl px-4 py-3">

        <input type="number" name="price" placeholder="Prix de vente"
               class="w-full border rounded-xl px-4 py-3">

        <input type="number" name="sale_price" placeholder="Prix promo (optionnel)"
               class="w-full border rounded-xl px-4 py-3">

        {{-- Stock --}}
        <input type="number" name="stock" value="0"
               class="w-full border rounded-xl px-4 py-3">

        {{-- Description --}}
        <textarea name="description" rows="3"
                  class="w-full border rounded-xl px-4 py-3"
                  placeholder="Description"></textarea>

        {{-- Image --}}
        <div>
            <label class="block mb-2 font-semibold">Image du produit</label>

            <input type="file"
                   name="image"
                   accept="image/*"
                   class="w-full border rounded-xl px-4 py-3">
        </div>

        {{-- Checkboxes --}}
        <div class="flex gap-6">

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" checked>
                <span>Actif</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_featured" value="1">
                <span>Vedette ⭐</span>
            </label>

        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold">
            ✅ Enregistrer
        </button>

    </form>

</div>

@endsection