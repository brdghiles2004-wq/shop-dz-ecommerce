@extends('layouts.app')
@section('title', '💄 Clients | Shop.dz')
@section('content')

<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-pink-600 text-sm">← Dashboard</a>
</div>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">👥 Clients inscrits</h1>
    <span class="bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-sm font-bold">
        {{ $users->total() }} clients
    </span>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-5 py-3 text-left">#</th>
                <th class="px-5 py-3 text-left">Nom</th>
                <th class="px-5 py-3 text-left">Email</th>
                <th class="px-5 py-3 text-left">Commandes</th>
                <th class="px-5 py-3 text-left">Inscrit le</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 {{ $user->created_at->isToday() ? 'bg-green-50' : '' }}">
                <td class="px-5 py-3 text-gray-400">#{{ $user->id }}</td>
                <td class="px-5 py-3 font-semibold">
                    <div class="flex items-center gap-2">
                        {{-- Avatar --}}
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center text-pink-600 font-bold text-xs">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        {{ $user->name }}
                        {{-- Badge Nouveau --}}
                        @if($user->created_at->isToday())
                            <span class="bg-green-100 text-green-600 text-xs px-2 py-0.5 rounded-full font-bold">
                                🆕 Nouveau
                            </span>
                        @endif
                    </div>
                </td>
                <td class="px-5 py-3 text-gray-500">{{ $user->email }}</td>
                <td class="px-5 py-3">
                    <span class="bg-pink-50 text-pink-600 px-2 py-1 rounded-full text-xs font-bold">
                        {{ $user->orders_count }}
                    </span>
                </td>
                <td class="px-5 py-3 text-gray-400">
                    {{ $user->created_at->format('d/m/Y') }}
                    <span class="text-xs text-gray-300 block">{{ $user->created_at->format('H:i') }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-10 text-center text-gray-400">Aucun client inscrit.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $users->links() }}</div>
</div>

@endsection