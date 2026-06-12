@extends('layouts.app')
@section('title', 'Catégories Admin')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">🏷️ Catégories</h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-pink-600 text-white px-5 py-2 rounded-lg hover:bg-pink-700 font-bold">
        + Ajouter
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-5 py-3 text-left">Nom</th>
                <th class="px-5 py-3 text-left">Slug</th>
                <th class="px-5 py-3 text-left">Produits</th>
                <th class="px-5 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($categories as $cat)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-semibold">{{ $cat->name }}</td>
                <td class="px-5 py-3 font-mono text-gray-500">{{ $cat->slug }}</td>
                <td class="px-5 py-3">{{ $cat->products_count }}</td>
                <td class="px-5 py-3 flex gap-3">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="text-blue-600 hover:underline">Modifier</a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette catégorie ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection