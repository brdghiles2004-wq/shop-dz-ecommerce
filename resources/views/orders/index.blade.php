@extends('layouts.app')
@section('title', 'Mes commandes — Shop.dz')
@section('content')

<h1 class="text-2xl font-bold mb-6">📦 Mes commandes</h1>

@if($orders->isEmpty())
    <div class="text-center py-16 bg-white rounded-xl shadow-sm">
        <p class="text-5xl mb-4">📦</p>
        <p class="text-gray-500">Vous n'avez pas encore de commandes.</p>
        <a href="{{ route('shop.index') }}" class="mt-4 inline-block bg-pink-600 text-white px-6 py-2 rounded-lg hover:bg-pink-700">
            Aller à la boutique
        </a>
    </div>
@else
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-6 py-3 text-left">Numéro</th>
                <th class="px-6 py-3 text-left">Date</th>
                <th class="px-6 py-3 text-left">Total</th>
                <th class="px-6 py-3 text-left">Statut</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-mono font-bold text-pink-600">{{ $order->order_number }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-4 font-bold">{{ number_format($order->total, 0) }} DA</td>
                <td class="px-6 py-4">{{ $order->status_label }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('orders.show', $order) }}" class="text-pink-600 hover:underline">Détails</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endif

@endsection