<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop.dz — Cosmétiques')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-pink-600">Shop.dz 💄</a>
        <div class="flex items-center gap-6 text-sm">
            <a href="{{ route('shop.index') }}" class="hover:text-pink-600 font-medium">Boutique</a>
            <a href="{{ route('cart.index') }}" class="relative hover:text-pink-600">
                <span class="text-xl">🛒</span>
                @php
                    $identifier = auth()->check()
                        ? ['user_id' => auth()->id()]
                        : ['session_id' => session()->getId()];
                    $cartCount = \App\Models\Cart::where($identifier)->sum('quantity');
                @endphp
                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                <a href="{{ route('orders.index') }}" class="hover:text-pink-600">Mes commandes</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="text-purple-600 font-bold hover:text-purple-800">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="hover:text-red-500">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-pink-600">Connexion</a>
                <a href="{{ route('register') }}" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition">S'inscrire</a>
            @endauth
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-6 py-3 text-sm">
        ✅ {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-800 px-6 py-3 text-sm">
        ❌ {{ session('error') }}
    </div>
@endif

<main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
</main>

<footer class="bg-pink-900 text-white mt-16 py-10 text-center">
    <p class="text-lg font-bold">Shop.dz 💄</p>
    <p class="text-pink-200 text-sm mt-1">© {{ date('Y') }} Shop.dz — Cosmétiques Algérie</p>
</footer>

</body>
</html>