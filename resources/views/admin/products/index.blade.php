@extends('layouts.app')
@section('title', 'Produits Admin')
@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">📦 Produits</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-pink-600 text-white px-5 py-2 rounded-lg hover:bg-pink-700 font-bold">
        + Ajouter
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
            <tr>
                <th class="px-5 py-3 text-left">Image</th>
                <th class="px-5 py-3 text-left">Nom</th>
                <th class="px-5 py-3 text-left">Catégorie</th>
                <th class="px-5 py-3 text-left">Prix</th>
                <th class="px-5 py-3 text-left">Stock</th>
                <th class="px-5 py-3 text-left">Actif</th>
                <th class="px-5 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="w-12 h-12 object-cover rounded-lg">
                    @else
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">💄</div>
                    @endif
                </td>
                <td class="px-5 py-3 font-semibold">{{ $product->name }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $product->category->name }}</td>
                <td class="px-5 py-3 font-bold text-pink-600">{{ number_format($product->final_price, 0) }} DA</td>
                <td class="px-5 py-3 {{ $product->stock < 5 ? 'text-red-600 font-bold' : 'text-gray-600' }}">{{ $product->stock }}</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 rounded-full text-xs {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $product->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </td>
                <td class="px-5 py-3 flex gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline">Modifier</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce produit ?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">{{ $products->links() }}</div>
</div>

@endsection