@extends('layouts.app')
@section('title', ' Mon Profil | Shop.dz')
@section('content')

<div class="max-w-4xl mx-auto">

   {{-- Header profil --}}
<div class="bg-gradient-to-r from-pink-500 to-pink-700 rounded-2xl p-8 mb-8 text-white flex items-center gap-6">
    <div class="w-20 h-20 bg-white rounded-full overflow-hidden flex items-center justify-center text-4xl shrink-0">
        @if($user->avatar)
            <img src="{{ $user->avatar }}" alt="Avatar" class="w-full h-full object-cover">
        @else
            {{ strtoupper(substr($user->name, 0, 1)) }}
        @endif
    </div>
    <div>
        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
        <p class="text-pink-200 text-sm mt-1">{{ $user->email }}</p>
        <p class="text-pink-200 text-xs mt-1">Membre depuis {{ $user->created_at->format('d/m/Y') }}</p>
    </div>
</div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">

        {{-- Modifier profil --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold mb-4">👤 Mes informations</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 rounded-lg px-4 py-3 mb-4 text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                        class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold hover:bg-pink-700 transition">
                    💾 Sauvegarder
                </button>
            </form>
        </div>

        {{-- Changer mot de passe --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold mb-4">🔒 Changer le mot de passe</h2>

            @if(session('error_password'))
                <div class="bg-red-100 text-red-700 rounded-lg px-4 py-3 mb-4 text-sm">
                    ❌ {{ session('error_password') }}
                </div>
            @endif

            <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                    <input type="password" name="current_password" placeholder="••••••••"
                           class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                           class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                </div>
                <button type="submit"
                        class="w-full bg-gray-800 text-white py-3 rounded-xl font-bold hover:bg-gray-900 transition">
                    🔑 Modifier
                </button>
            </form>
        </div>
    </div>

    {{-- Dernières commandes --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mt-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">📦 Mes dernières commandes</h2>
            <a href="{{ route('orders.index') }}" class="text-pink-600 text-sm hover:underline">Voir tout →</a>
        </div>

        @if($orders->isEmpty())
            <div class="text-center py-8 text-gray-400">
                <p class="text-4xl mb-2">📦</p>
                <p>Vous n'avez pas encore de commandes.</p>
                <a href="{{ route('shop.index') }}" class="mt-3 inline-block bg-pink-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-pink-700">
                    Découvrir la boutique
                </a>
            </div>
        @else
        <div class="overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Numéro</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-left">Statut</th>
                        <th class="px-4 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono font-bold text-pink-600">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 font-bold">{{ number_format($order->total, 0) }} DA</td>
                        <td class="px-4 py-3">{{ $order->status_label }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('orders.show', $order) }}" class="text-pink-600 hover:underline text-xs">
                                Détails →
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@endsection