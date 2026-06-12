@extends('layouts.app')
@section('title', 'Commande ' . $order->order_number)
@section('content')

<div class="bg-white rounded-xl shadow-sm p-8 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-2">Commande {{ $order->order_number }}</h1>
    <p class="text-gray-500 text-sm mb-6">{{ $order->created_at->format('d/m/Y à H:i') }}</p>

    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
        <div>
            <p class="text-gray-500">Livraison à</p>
            <p class="font-semibold">{{ $order->shipping_name }}</p>
            <p>{{ $order->shipping_address }}, {{ $order->shipping_city }}</p>
            <p>{{ $order->wilaya }}</p>
            <p>📞 {{ $order->shipping_phone }}</p>
        </div>
        <div class="text-right">
            <p class="text-gray-500">Statut</p>
            <p class="text-xl">{{ $order->status_label }}</p>
        </div>
    </div>

    <div class="border rounded-xl overflow-hidden mb-6">
        @foreach($order->items as $item)
        <div class="flex items-center gap-4 p-4 border-b last:border-0">
            @if($item->product->image)
                <img src="{{ Storage::url($item->product->image) }}" class="w-14 h-14 object-cover rounded-lg">
            @else
                <div class="w-14 h-14 bg-pink-100 rounded-lg flex items-center justify-center text-xl">💄</div>
            @endif
            <div class="flex-1">
                <p class="font-semibold">{{ $item->product->name }}</p>
                <p class="text-gray-500 text-sm">{{ number_format($item->price, 0) }} DA × {{ $item->quantity }}</p>
            </div>
            <p class="font-bold">{{ number_format($item->price * $item->quantity, 0) }} DA</p>
        </div>
        @endforeach
    </div>

    <div class="flex justify-between text-xl font-bold text-pink-600 border-t pt-4">
        <span>Total</span>
        <span>{{ number_format($order->total, 0) }} DA</span>
    </div>
</div>

@endsection