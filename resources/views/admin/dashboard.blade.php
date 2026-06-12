@extends('layouts.app')
@section('title', 'Dashboard Admin — Shop.dz')
@section('content')

<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold">📊 Dashboard Admin</h1>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10">
    <div class="bg-white rounded-xl p-5 shadow-sm text-center">
        <p class="text-3xl font-bold text-pink-600">{{ $stats['total_orders'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Commandes</p>
    </div>
    <div class="bg-yellow-50 rounded-xl p-5 shadow-sm text-center">
        <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_orders'] }}</p>
        <p class="text-gray-500 text-sm mt-1">En attente</p>
    </div>
    <div class="bg-blue-50 rounded-xl p-5 shadow-sm text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_products'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Produits</p>
    </div>
    <div class="bg-green-50 rounded-xl p-5 shadow-sm text-center">
        <p class="text-3xl font-bold text-green-600">{{ $stats['total_users'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Clients</p>
    </div>
    <div class="bg-pink-50 rounded-xl p-5 shadow-sm text-center">
        <p class="text-3xl font-bold text-pink-600">{{ number_format($stats['revenue'], 0) }}</p>
        <p class="text-gray-500 text-sm mt-1">DA Revenus</p>
    </div>
</div>

<div class="grid md:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('admin.products.create') }}" class="bg-pink-600 text-white rounded-xl p-4 text-center hover:bg-pink-700 transition">
        <p class="text-2xl mb-1">➕</p><p class="font-bold">Ajouter produit</p>
    </a>
    <a href="{{ route('admin.products.index') }}" class="bg-blue-500 text-white rounded-xl p-4 text-center hover:bg-blue-600 transition">
        <p class="text-2xl mb-1">📦</p><p class="font-bold">Produits</p>
    </a>
    <a href="{{ route('admin.categories.index') }}" class="bg-purple-500 text-white rounded-xl p-4 text-center hover:bg-purple-600 transition">
        <p class="text-2xl mb-1">🏷️</p><p class="font-bold">Catégories</p>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="bg-orange-500 text-white rounded-xl p-4 text-center hover:bg-orange-600 transition">
        <p class="text-2xl mb-1">📋</p><p class="font-bold">Commandes</p>
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-5 border-b"><h2 class="font-bold text-lg">Dernières commandes</h2></div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-5 py-3 text-left">Numéro</th>
                <th class="px-5 py-3 text-left">Client</th>
                <th class="px-5 py-3 text-left">Total</th>
                <th class="px-5 py-3 text-left">Statut</th>
                <th class="px-5 py-3 text-left">Date</th>
                <th class="px-5 py-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($recentOrders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono font-bold text-pink-600">{{ $order->order_number }}</td>
                <td class="px-5 py-3">{{ $order->user->name }}</td>
                <td class="px-5 py-3 font-bold">{{ number_format($order->total, 0) }} DA</td>
                <td class="px-5 py-3">{{ $order->status_label }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $order->created_at->format('d/m/Y') }}</td>
                <td class="px-5 py-3">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-pink-600 hover:underline">Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection