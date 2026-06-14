@extends('layouts.app')
@section('title', '💄 Ticket #' . $ticket->id)
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.support.index') }}" class="text-gray-400 hover:text-pink-600">← Retour</a>
        <h1 class="text-xl font-bold">Ticket #{{ $ticket->id }} — {{ $ticket->subject }}</h1>
    </div>

    {{-- Info client --}}
    <div class="bg-gray-50 rounded-xl p-4 mb-4 text-sm">
        <p><span class="text-gray-500">Client:</span> <strong>{{ $ticket->client_name }}</strong></p>
        <p><span class="text-gray-500">Email:</span> {{ $ticket->client_email }}</p>
        <p><span class="text-gray-500">Date:</span> {{ $ticket->created_at->format('d/m/Y à H:i') }}</p>
        <p><span class="text-gray-500">Statut:</span> {{ $ticket->status_label }}</p>
    </div>

    {{-- Message client --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <p class="text-sm font-bold text-gray-700 mb-2">Message du client :</p>
        <p class="text-gray-700 text-sm leading-relaxed">{{ $ticket->message }}</p>
    </div>

    {{-- Réponse existante --}}
    @if($ticket->admin_reply)
    <div class="bg-pink-50 border-l-4 border-pink-500 rounded-xl p-5 mb-6">
        <p class="text-sm font-bold text-pink-700 mb-2">Votre réponse précédente :</p>
        <p class="text-gray-700 text-sm">{{ $ticket->admin_reply }}</p>
    </div>
    @endif

    {{-- Formulaire réponse --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-bold mb-4">{{ $ticket->admin_reply ? '✏️ Modifier la réponse' : '💬 Répondre' }}</h2>
        <form action="{{ route('admin.support.reply', $ticket) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Votre réponse</label>
                <textarea name="admin_reply" rows="5"
                          placeholder="Écrivez votre réponse..."
                          class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">{{ old('admin_reply', $ticket->admin_reply) }}</textarea>
                @error('admin_reply') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status" class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
                    <option value="open"     {{ $ticket->status === 'open'     ? 'selected' : '' }}>🟡 En attente</option>
                    <option value="answered" {{ $ticket->status === 'answered' ? 'selected' : '' }}>🟢 Répondu</option>
                    <option value="closed"   {{ $ticket->status === 'closed'   ? 'selected' : '' }}>🔴 Fermé</option>
                </select>
            </div>
            <button type="submit"
                    class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold hover:bg-pink-700 transition">
                📨 Envoyer la réponse
            </button>
        </form>
    </div>
</div>

@endsection