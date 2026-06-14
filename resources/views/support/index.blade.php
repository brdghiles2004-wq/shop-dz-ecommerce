@extends('layouts.app')
@section('title', ' Support | Shop.dz')
@section('content')

<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">💬 Support Client</h1>

    {{-- Formulaire --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <h2 class="text-lg font-bold mb-4">Envoyer un message</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 rounded-lg px-4 py-3 mb-4 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('support.store') }}" method="POST" class="space-y-4">
            @csrf

            @guest
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="guest_email" value="{{ old('guest_email') }}"
                           class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                </div>
            </div>
            @else
            <input type="hidden" name="name" value="{{ auth()->user()->name }}">
            @endguest

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
                <select name="subject" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    <option value="">-- Choisir un sujet --</option>
                    <option value="Problème avec ma commande" {{ old('subject') == 'Problème avec ma commande' ? 'selected' : '' }}>📦 Problème avec ma commande</option>
                    <option value="Retard de livraison" {{ old('subject') == 'Retard de livraison' ? 'selected' : '' }}>🚚 Retard de livraison</option>
                    <option value="Produit défectueux" {{ old('subject') == 'Produit défectueux' ? 'selected' : '' }}>⚠️ Produit défectueux</option>
                    <option value="Remboursement" {{ old('subject') == 'Remboursement' ? 'selected' : '' }}>💰 Remboursement</option>
                    <option value="Question sur un produit" {{ old('subject') == 'Question sur un produit' ? 'selected' : '' }}>❓ Question sur un produit</option>
                    <option value="Autre" {{ old('subject') == 'Autre' ? 'selected' : '' }}>💬 Autre</option>
                </select>
                @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea name="message" rows="5"
                          placeholder="Décrivez votre problème en détail..."
                          class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">{{ old('message') }}</textarea>
                @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold hover:bg-pink-700 transition">
                📨 Envoyer le message
            </button>
        </form>
    </div>

    {{-- Mes tickets (auth only) --}}
    @auth
    @if($tickets && $tickets->count())
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-bold mb-4">Mes messages précédents</h2>
        <div class="space-y-3">
            @foreach($tickets as $ticket)
            <a href="{{ route('support.show', $ticket) }}"
               class="flex items-center justify-between p-4 border rounded-xl hover:border-pink-300 hover:bg-pink-50 transition">
                <div>
                    <p class="font-semibold text-gray-800 text-sm">{{ $ticket->subject }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="text-xs font-bold">{{ $ticket->status_label }}</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif
    @endauth
</div>

@endsection