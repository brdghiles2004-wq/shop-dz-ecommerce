@extends('layouts.app')
@section('title', ' Ticket Support | Shop.dz')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('support.index') }}" class="text-gray-400 hover:text-pink-600">← Retour</a>
        <h1 class="text-xl font-bold">{{ $ticket->subject }}</h1>
    </div>

    {{-- Message client --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
        <div class="flex justify-between items-start mb-3">
            <div>
                <p class="font-bold text-gray-800">{{ $ticket->client_name }}</p>
                <p class="text-xs text-gray-400">{{ $ticket->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <span class="text-sm">{{ $ticket->status_label }}</span>
        </div>
        <p class="text-gray-700 text-sm leading-relaxed">{{ $ticket->message }}</p>
    </div>

    {{-- Réponse admin --}}
    @if($ticket->admin_reply)
    <div class="bg-pink-50 border-l-4 border-pink-500 rounded-xl p-6">
        <div class="flex justify-between items-start mb-3">
            <p class="font-bold text-pink-700">💄 Shop.dz — Support</p>
            <p class="text-xs text-gray-400">{{ $ticket->replied_at?->format('d/m/Y à H:i') }}</p>
        </div>
        <p class="text-gray-700 text-sm leading-relaxed">{{ $ticket->admin_reply }}</p>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center text-sm text-yellow-700">
        ⏳ En attente de réponse — nous vous répondrons dans les plus brefs délais.
    </div>
    @endif
</div>

@endsection