@extends('layouts.app')
@section('title', ' Support Admin | Shop.dz')
@section('content')

<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-pink-600 text-sm">← Dashboard</a>
</div>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">💬 Tickets Support</h1>
    <div class="flex gap-2 text-sm">
        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-bold">
            🟡 {{ $tickets->where('status', 'open')->count() }} en attente
        </span>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-5 py-3 text-left">#</th>
                <th class="px-5 py-3 text-left">Client</th>
                <th class="px-5 py-3 text-left">Sujet</th>
                <th class="px-5 py-3 text-left">Statut</th>
                <th class="px-5 py-3 text-left">Date</th>
                <th class="px-5 py-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($tickets as $ticket)
            <tr class="hover:bg-gray-50 {{ $ticket->status === 'open' ? 'bg-yellow-50' : '' }}">
                <td class="px-5 py-3 font-mono text-gray-400">#{{ $ticket->id }}</td>
                <td class="px-5 py-3">
                    <p class="font-semibold">{{ $ticket->client_name }}</p>
                    <p class="text-xs text-gray-400">{{ $ticket->client_email }}</p>
                </td>
                <td class="px-5 py-3 font-medium">{{ $ticket->subject }}</td>
                <td class="px-5 py-3">{{ $ticket->status_label }}</td>
                <td class="px-5 py-3 text-gray-400">{{ $ticket->created_at->format('d/m/Y') }}</td>
                <td class="px-5 py-3">
                    <a href="{{ route('admin.support.show', $ticket) }}"
                       class="bg-pink-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-pink-700">
                        Répondre
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-10 text-center text-gray-400">Aucun ticket pour le moment.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $tickets->links() }}</div>
</div>

@endsection