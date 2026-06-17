@extends('layouts.app')
@section('title', $product->name . ' | Shop.dz')
@section('content')

<div class="bg-white rounded-2xl shadow-sm p-8">
    <div class="grid md:grid-cols-2 gap-10">
        <div>
            @if($product->image)
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full rounded-xl">
            @else
                <div class="w-full h-80 bg-pink-100 rounded-xl flex items-center justify-center text-7xl">💄</div>
            @endif
        </div>
        <div>
            <p class="text-sm text-pink-600 font-medium mb-2">{{ $product->category->name }}</p>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
            <div class="flex items-center gap-4 mb-6">
                <span class="text-3xl font-bold text-pink-600">{{ number_format($product->final_price, 0) }} DA</span>
                @if($product->sale_price)
                    <span class="text-xl text-gray-400 line-through">{{ number_format($product->price, 0) }} DA</span>
                    <span class="bg-red-100 text-red-600 text-sm px-2 py-1 rounded-full font-bold">PROMO</span>
                @endif
            </div>
            <p class="text-gray-600 mb-6">{{ $product->description }}</p>
            <p class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} mb-6">
                {{ $product->stock > 0 ? '✅ En stock (' . $product->stock . ' disponibles)' : '❌ Rupture de stock' }}
            </p>
            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                       class="w-20 border rounded-lg px-3 py-2 text-center">
                <button class="flex-1 bg-pink-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-pink-700 transition">
                    🛒 Ajouter au panier
                </button>
            </form>
            @endif
        </div>
    </div>
</div>

@if($related->count())
<div class="mt-12">
    <h2 class="text-xl font-bold mb-5">Produits similaires</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
        @foreach($related as $p)
        <a href="{{ route('shop.show', $p->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-3 block">
            @if($p->image)
                <img src="{{ $p->image }}" class="w-full h-36 object-cover rounded-lg mb-2">
            @else
                <div class="w-full h-36 bg-pink-100 rounded-lg flex items-center justify-center text-3xl mb-2">💄</div>
            @endif
            <p class="text-sm font-semibold text-gray-800">{{ $p->name }}</p>
            <p class="text-pink-600 font-bold text-sm mt-1">{{ number_format($p->final_price, 0) }} DA</p>
        </a>
        @endforeach
    </div>
</div>
@endif

@endsection