@extends('layouts.app')
@section('title', 'Commande ' . $order->order_number)
@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8">
    <h1 class="text-2xl font-bold mb-6">Commande {{ $order->order_number }}</h1>

    <div class="bg-gray-50 rounded-xl p-4 mb-6 text-sm space-y-1">
    <p><span class="text-gray-500">Client:</span> <strong>{{ $order->user?->name ?? 'Invité' }}</strong> — {{ $order->user?->email ?? $order->guest_email ?? '—' }}</p>        <p><span class="text-gray-500">Téléphone:</span> {{ $order->shipping_phone }}</p>
        <p><span class="text-gray-500">Adresse:</span> {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->wilaya }}</p>
        @if($order->notes)
        <p><span class="text-gray-500">Notes:</span> {{ $order->notes }}</p>
        @endif
    </div>

    <div class="mb-6">
        @foreach($order->items as $item)
        <div class="flex justify-between py-2 border-b text-sm">
            <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
            <span class="font-bold">{{ number_format($item->price * $item->quantity, 0) }} DA</span>
        </div>
        @endforeach
        <div class="flex justify-between pt-3 font-bold text-pink-600 text-lg">
            <span>Total</span>
            <span>{{ number_format($order->total, 0) }} DA</span>
        </div>
    </div>

    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex gap-3">
        @csrf @method('PUT')
        <select name="status" class="flex-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
            <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>
                {{ ucfirst($s) }}
            </option>
            @endforeach
        </select>
        <button class="bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition font-bold">
            Mettre à jour
        </button>
    </form>
</div>

@endsection