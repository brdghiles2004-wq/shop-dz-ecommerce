@extends('layouts.app')
@section('title', ' Commandes Admin')
@section('content')

<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-pink-600 text-sm">← Dashboard</a>
</div>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">📋 Toutes les commandes</h1>
    @php $pendingCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
    @if($pendingCount > 0)
        <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-bold">
            ⏳ {{ $pendingCount }} en attente
        </span>
    @endif
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-5 py-3 text-left">Numéro</th>
                <th class="px-5 py-3 text-left">Client</th>
                <th class="px-5 py-3 text-left">Wilaya</th>
                <th class="px-5 py-3 text-left">Total</th>
                <th class="px-5 py-3 text-left">Statut</th>
                <th class="px-5 py-3 text-left">Date</th>
                <th class="px-5 py-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($orders as $order)
            <tr class="hover:bg-gray-50 {{ $order->status === 'pending' ? 'bg-orange-50' : '' }}">
                <td class="px-5 py-3 font-mono font-bold text-pink-600">
                    {{ $order->order_number }}
                    @if($order->created_at->isToday())
                        <span class="block text-xs bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded-full w-fit mt-1">
                            🆕 Nouvelle
                        </span>
                    @endif
                </td>
                <td class="px-5 py-3">{{ $order->user?->name ?? $order->guest_email ?? 'Invité' }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $order->wilaya }}</td>
                <td class="px-5 py-3 font-bold">{{ number_format($order->total, 0) }} DA</td>
                <td class="px-5 py-3">{{ $order->status_label }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-5 py-3">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-pink-600 hover:underline">Gérer</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">{{ $orders->links() }}</div>
</div>

@endsections