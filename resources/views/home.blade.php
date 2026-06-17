@extends('layouts.app')
@section('title', '💄 Accueil | Shop.dz')
@section('content')

{{-- Hero --}}
<div class="bg-gradient-to-r from-pink-500 to-pink-700 text-white rounded-2xl p-12 mb-12 text-center">
    <h1 class="text-4xl font-bold mb-4">Bienvenue sur Shop.dz 💄</h1>
    <p class="text-pink-100 text-lg mb-6">Les meilleurs cosmétiques livrés partout en Algérie</p>
    <a href="{{ route('shop.index') }}" class="bg-white text-pink-700 font-bold px-8 py-3 rounded-full hover:bg-pink-50 transition">
        Découvrir la boutique →
    </a>
</div>

{{-- Catégories --}}
@if($categories->count())
<div class="mb-12">
    <h2 class="text-2xl font-bold mb-6">Nos catégories</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @foreach($categories as $cat)
        <a href="{{ route('shop.index', ['category' => $cat->slug]) }}"
           class="bg-white rounded-xl p-4 text-center shadow-sm hover:shadow-md hover:border-pink-300 border border-transparent transition">
            <p class="font-semibold text-gray-700">{{ $cat->name }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $cat->products_count }} produits</p>
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- Produits vedettes --}}
@if($featuredProducts->count())
<div>
    <h2 class="text-2xl font-bold mb-6">Produits vedettes ⭐</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($featuredProducts as $product)
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
            <a href="{{ route('shop.show', $product->slug) }}">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-pink-100 flex items-center justify-center text-4xl">💄</div>
                @endif
            </a>
            <div class="p-4">
                <a href="{{ route('shop.show', $product->slug) }}" class="font-semibold text-sm text-gray-800 hover:text-pink-600">
                    {{ $product->name }}
                </a>
                <p class="text-xs text-gray-500 mt-1">{{ $product->category->name }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-pink-600 font-bold">{{ number_format($product->final_price, 0) }} DA</span>
                    @if($product->sale_price)
                        <span class="text-gray-400 line-through text-xs">{{ number_format($product->price, 0) }} DA</span>
                    @endif
                </div>
                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button class="w-full bg-pink-600 text-white py-2 rounded-lg text-sm hover:bg-pink-700 transition">
                        🛒 Ajouter au panier
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection