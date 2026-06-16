<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop.dz — Cosmétiques')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💄</text></svg>">
</head>
<body class="bg-gray-50 text-gray-800">

@auth
@if(auth()->user()->is_admin && request()->is('admin*'))

{{-- ═══ LAYOUT ADMIN (avec sidebar) ═══ --}}
<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-56 bg-pink-900 text-white flex flex-col fixed h-full">
        <div class="p-5 border-b border-pink-800">
            <a href="{{ route('home') }}" class="text-xl font-bold">Shop.dz 💄</a>
            <p class="text-pink-300 text-xs mt-1">Panel Admin</p>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
               {{ request()->is('admin/dashboard') ? 'bg-pink-700 text-white' : 'text-pink-200 hover:bg-pink-800' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
               {{ request()->is('admin/products*') ? 'bg-pink-700 text-white' : 'text-pink-200 hover:bg-pink-800' }}">
                📦 Produits
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
               {{ request()->is('admin/categories*') ? 'bg-pink-700 text-white' : 'text-pink-200 hover:bg-pink-800' }}">
                🏷️ Catégories
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
               {{ request()->is('admin/orders*') ? 'bg-pink-700 text-white' : 'text-pink-200 hover:bg-pink-800' }}">
                📋 Commandes
            </a>

            {{-- Support avec badge tickets en attente --}}
            <a href="{{ route('admin.support.index') }}"
               class="flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition
               {{ request()->is('admin/support*') ? 'bg-pink-700 text-white' : 'text-pink-200 hover:bg-pink-800' }}">
                <span>💬 Support</span>
                @php $openTickets = \App\Models\SupportTicket::where('status', 'open')->count(); @endphp
                @if($openTickets > 0)
                    <span class="bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                        {{ $openTickets }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.stats.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
               {{ request()->is('admin/stats*') ? 'bg-pink-700 text-white' : 'text-pink-200 hover:bg-pink-800' }}">
                📊 Statistiques
            </a>

            {{-- Clients avec badge nouveaux clients aujourd'hui --}}
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition
               {{ request()->is('admin/users*') ? 'bg-pink-700 text-white' : 'text-pink-200 hover:bg-pink-800' }}">
                <span>👥 Clients</span>
                @php $newUsers = \App\Models\User::where('is_admin', false)->whereDate('created_at', today())->count(); @endphp
                @if($newUsers > 0)
                    <span class="bg-green-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                        {{ $newUsers }}
                    </span>
                @endif
            </a>
        </nav>
        <div class="p-4 border-t border-pink-800">
            <a href="{{ route('home') }}" class="block text-pink-300 text-xs hover:text-white mb-2">🌐 Voir le site</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-pink-300 text-xs hover:text-white">🚪 Déconnexion</button>
            </form>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 ml-56">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <p class="text-gray-500 text-sm">Bonjour, <span class="font-bold text-gray-800">{{ auth()->user()->name }}</span> 👋</p>
            <span class="bg-pink-100 text-pink-700 text-xs font-bold px-3 py-1 rounded-full">ADMIN</span>
        </header>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-6 py-3 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <main class="p-8">
            @yield('content')
        </main>
    </div>
</div>

@else
{{-- ═══ LAYOUT NORMAL (navbar) ═══ --}}

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
            <a href="{{ route('orders.index') }}" class="hover:text-pink-600">Mes commandes</a>
            <a href="{{ route('profile.index') }}" class="flex items-center gap-2 hover:text-pink-600">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" class="w-6 h-6 rounded-full">
                @endif
                Mon profil
            </a>

            {{-- Support avec badge notification client --}}
            @php
                $newReplies = \App\Models\SupportTicket::where('user_id', auth()->id())
                    ->where('status', 'answered')
                    ->whereNotNull('admin_reply')
                    ->where('replied_at', '>', auth()->user()->last_seen_support ?? '2000-01-01')
                    ->count();
            @endphp
            <a href="{{ route('support.index') }}" class="relative hover:text-pink-600">
                Support
                @if($newReplies > 0)
                    <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold">
                        {{ $newReplies }}
                    </span>
                @endif
            </a>

            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="text-purple-600 font-bold hover:text-purple-800">Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="hover:text-red-500">Déconnexion</button>
            </form>
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

@endif
@else
{{-- Guest --}}
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-pink-600">Shop.dz 💄</a>
        <div class="flex items-center gap-6 text-sm">
            <a href="{{ route('shop.index') }}" class="hover:text-pink-600 font-medium">Boutique</a>
            <a href="{{ route('cart.index') }}" class="relative hover:text-pink-600">
                <span class="text-xl">🛒</span>
                @php
                    $cartCount = \App\Models\Cart::where('session_id', session()->getId())->sum('quantity');
                @endphp
                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                @endif
            </a>
            <a href="{{ route('support.index') }}" class="hover:text-pink-600">Support</a>
            <a href="{{ route('login') }}" class="hover:text-pink-600">Connexion</a>
            <a href="{{ route('register') }}" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition">S'inscrire</a>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-6 py-3 text-sm">
        ✅ {{ session('success') }}
    </div>
@endif

<main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
</main>

<footer class="bg-pink-900 text-white mt-16 py-10 text-center">
    <p class="text-lg font-bold">Shop.dz 💄</p>
    <p class="text-pink-200 text-sm mt-1">© {{ date('Y') }} Shop.dz — Cosmétiques Algérie</p>
</footer>

@endauth

</body>
</html>