@extends('layouts.app')
@section('title', 'Commande — Shop.dz')
@section('content')

<h1 class="text-2xl font-bold mb-6">📦 Finaliser la commande</h1>

<div class="grid md:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-bold mb-4">Informations de livraison</h2>
        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('shipping_name') border-red-500 @enderror">
                @error('shipping_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('shipping_phone') border-red-500 @enderror">
                @error('shipping_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Wilaya</label>
                <input type="text" name="wilaya" value="{{ old('wilaya') }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('wilaya') border-red-500 @enderror">
                @error('wilaya') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('shipping_city') border-red-500 @enderror">
                @error('shipping_city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse complète</label>
                <textarea name="shipping_address" rows="2"
                          class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('shipping_address') border-red-500 @enderror">{{ old('shipping_address') }}</textarea>
                @error('shipping_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optionnel)</label>
                <textarea name="notes" rows="2" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">{{ old('notes') }}</textarea>
            </div>
            <button type="submit"
                    class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-pink-700 transition">
                ✅ Confirmer la commande
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 h-fit">
        <h2 class="text-lg font-bold mb-4">Votre commande</h2>
        @foreach($cartItems as $item)
        <div class="flex justify-between text-sm py-2 border-b last:border-0">
            <span class="text-gray-700">{{ $item->product->name }} × {{ $item->quantity }}</span>
            <span class="font-bold">{{ number_format($item->product->final_price * $item->quantity, 0) }} DA</span>
        </div>
        @endforeach
        <div class="flex justify-between font-bold text-lg mt-4 pt-3 border-t text-pink-600">
            <span>Total</span>
            <span>{{ number_format($total, 0) }} DA</span>
        </div>
        <p class="text-xs text-gray-400 mt-3 text-center">💳 Paiement à la livraison (Cash)</p>
    </div>
</div>

@endsection