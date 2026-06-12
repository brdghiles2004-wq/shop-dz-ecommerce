@extends('layouts.app')
@section('title', 'Panier — Shop.dz')
@section('content')

<h1 class="text-2xl font-bold mb-6">🛒 Mon Panier</h1>

@if($cartItems->isEmpty())
    <div class="text-center py-20 bg-white rounded-xl shadow-sm">
        <p class="text-6xl mb-4">🛒</p>
        <p class="text-gray-500 text-lg">Votre panier est vide.</p>
        <a href="{{ route('shop.index') }}" class="mt-4 inline-block bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700">
            Aller à la boutique
        </a>
    </div>
@else
<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 space-y-3">
        @foreach($cartItems as $item)
        <div class="bg-white rounded-xl shadow-sm p-4 flex items-center gap-4">
            @if($item->product->image)
                <img src="{{ Storage::url($item->product->image) }}" class="w-20 h-20 object-cover rounded-lg">
            @else
                <div class="w-20 h-20 bg-pink-100 rounded-lg flex items-center justify-center text-2xl">💄</div>
            @endif
            <div class="flex-1">
                <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                <p class="text-pink-600 font-bold">{{ number_format($item->product->final_price, 0) }} DA</p>
            </div>
            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                       class="w-16 border rounded-lg px-2 py-1 text-center text-sm">
                <button class="text-blue-500 text-sm hover:text-blue-700">✓</button>
            </form>
            <p class="font-bold w-24 text-right">{{ number_format($item->product->final_price * $item->quantity, 0) }} DA</p>
            <form action="{{ route('cart.remove', $item) }}" method="POST">
                @csrf @method('DELETE')
                <button class="text-red-400 hover:text-red-600 text-xl">✕</button>
            </form>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 h-fit">
        <h2 class="text-lg font-bold mb-4">Récapitulatif</h2>
        <div class="flex justify-between text-gray-600 mb-2">
            <span>Sous-total</span>
            <span>{{ number_format($total, 0) }} DA</span>
        </div>
        <div class="flex justify-between text-gray-600 mb-4">
            <span>Livraison</span>
            <span class="text-green-600">Gratuite</span>
        </div>
        <div class="border-t pt-3 flex justify-between font-bold text-lg mb-6">
            <span>Total</span>
            <span class="text-pink-600">{{ number_format($total, 0) }} DA</span>
        </div>
        <a href="{{ route('checkout.index') }}"
           class="block w-full bg-pink-600 text-white text-center py-3 rounded-xl font-bold hover:bg-pink-700 transition">
            Commander →
        </a>
    </div>
</div>
@endif

@endsection