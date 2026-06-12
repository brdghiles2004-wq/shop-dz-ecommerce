@extends('layouts.app')
@section('title', 'Boutique — Shop.dz')
@section('content')

<div class="flex gap-8">

    {{-- Sidebar filtres --}}
    <aside class="w-56 shrink-0">
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <h3 class="font-bold mb-3">Catégories</h3>
            <a href="{{ route('shop.index') }}"
               class="block py-1 text-sm {{ !request('category') ? 'text-pink-600 font-bold' : 'text-gray-600 hover:text-pink-600' }}">
                Tout voir
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('shop.index', ['category' => $cat->slug]) }}"
               class="block py-1 text-sm {{ request('category') == $cat->slug ? 'text-pink-600 font-bold' : 'text-gray-600 hover:text-pink-600' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </aside>

    {{-- Produits --}}
    <div class="flex-1">
        {{-- Barre de recherche + tri --}}
        <form method="GET" action="{{ route('shop.index') }}" class="flex gap-3 mb-6">
            <input type="hidden" name="category" value="{{ request('category') }}">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un produit..."
                   class="flex-1 border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-300">
            <select name="sort" class="border rounded-lg px-3 py-2 text-sm focus:outline-none">
                <option value="">Trier par</option>
                <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Prix ↑</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix ↓</option>
            </select>
            <button class="bg-pink-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-pink-700">Filtrer</button>
        </form>

        @if($products->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <p class="text-5xl mb-4">🔍</p>
                <p>Aucun produit trouvé.</p>
            </div>
        @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($products as $product)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                <a href="{{ route('shop.show', $product->slug) }}">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-44 object-cover">
                    @else
                        <div class="w-full h-44 bg-pink-100 flex items-center justify-center text-4xl">💄</div>
                    @endif
                </a>
                <div class="p-3">
                    <a href="{{ route('shop.show', $product->slug) }}" class="font-semibold text-sm text-gray-800 hover:text-pink-600 line-clamp-2">
                        {{ $product->name }}
                    </a>
                    <p class="text-xs text-gray-400 mt-1">{{ $product->category->name }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-pink-600 font-bold text-sm">{{ number_format($product->final_price, 0) }} DA</span>
                        @if($product->sale_price)
                            <span class="text-gray-400 line-through text-xs">{{ number_format($product->price, 0) }} DA</span>
                        @endif
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button class="w-full bg-pink-600 text-white py-1.5 rounded-lg text-xs hover:bg-pink-700 transition">
                            🛒 Ajouter
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $products->links() }}</div>
        @endif
    </div>
</div>

@endsection