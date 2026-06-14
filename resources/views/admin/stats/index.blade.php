@extends('layouts.app')
@section('title', ' Statistiques | Shop.dz')
@section('content')

<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-pink-600 text-sm">← Dashboard</a>
</div>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">📊 Statistiques mensuelles</h1>

    <form method="GET" action="{{ route('admin.stats.index') }}">
        <select name="month" onchange="this.form.submit()"
                class="border rounded-xl px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            @foreach($availableMonths as $m)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($m . '-01')->translatedFormat('F Y') }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<p class="text-gray-500 text-sm mb-6">
    Période : {{ $start->translatedFormat('d F Y') }} — {{ $start->copy()->endOfMonth()->translatedFormat('d F Y') }}
</p>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-green-50 rounded-xl p-5 shadow-sm">
        <p class="text-gray-500 text-sm">💰 Revenu total</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($stats['revenue'], 0) }} DA</p>
        <p class="text-xs text-gray-400 mt-1">{{ $stats['orders_count'] }} commandes livrées</p>
    </div>

    <div class="bg-blue-50 rounded-xl p-5 shadow-sm">
        <p class="text-gray-500 text-sm">📦 Coût d'achat</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($stats['cost'], 0) }} DA</p>
        <p class="text-xs text-gray-400 mt-1">Coût des produits vendus</p>
    </div>

    <div class="bg-pink-50 rounded-xl p-5 shadow-sm">
        <p class="text-gray-500 text-sm">📈 Bénéfice net</p>
        <p class="text-2xl font-bold {{ $stats['profit'] >= 0 ? 'text-pink-600' : 'text-red-600' }} mt-1">
            {{ number_format($stats['profit'], 0) }} DA
        </p>
        <p class="text-xs text-gray-400 mt-1">Revenu - Coût</p>
    </div>

    <div class="bg-red-50 rounded-xl p-5 shadow-sm">
        <p class="text-gray-500 text-sm">⚠️ Pertes (annulées)</p>
        <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($stats['loss_revenue'], 0) }} DA</p>
        <p class="text-xs text-gray-400 mt-1">{{ $stats['cancelled_count'] }} commandes annulées</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-bold mb-4">📋 Résumé</h2>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Commandes livrées</span>
                <span class="font-bold text-green-600">{{ $stats['orders_count'] }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Commandes en cours</span>
                <span class="font-bold text-yellow-600">{{ $stats['pending_count'] }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Commandes annulées</span>
                <span class="font-bold text-red-600">{{ $stats['cancelled_count'] }}</span>
            </div>
            <div class="flex justify-between py-2 border-b">
                <span class="text-gray-600">Revenu livraison</span>
                <span class="font-bold">{{ number_format($stats['shipping_revenue'], 0) }} DA</span>
            </div>
            <div class="flex justify-between py-2">
                <span class="text-gray-600">Coût produits annulés</span>
                <span class="font-bold text-red-500">{{ number_format($stats['loss_cost'], 0) }} DA</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-bold mb-4">💡 Analyse</h2>
        <div class="space-y-3 text-sm text-gray-600">
            @if($stats['profit'] > 0)
                <p class="text-green-600 font-medium">✅ Mois bénéficiaire de {{ number_format($stats['profit'], 0) }} DA</p>
            @elseif($stats['profit'] < 0)
                <p class="text-red-600 font-medium">⚠️ Mois déficitaire de {{ number_format(abs($stats['profit']), 0) }} DA</p>
            @else
                <p class="text-gray-500">— Aucune activité ce mois</p>
            @endif

            @if($stats['cancelled_count'] > 0)
                <p>📉 {{ $stats['cancelled_count'] }} commande(s) annulée(s) représentant
                   <strong class="text-red-600">{{ number_format($stats['loss_revenue'], 0) }} DA</strong>
                   de revenu perdu.</p>
            @endif

            @if($stats['orders_count'] > 0)
                <p>💵 Marge moyenne par commande :
                   <strong class="text-pink-600">{{ number_format($stats['profit'] / $stats['orders_count'], 0) }} DA</strong>
                </p>
            @endif
        </div>
    </div>
</div>

@endsection