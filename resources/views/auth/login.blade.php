<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Shop.dz </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="text-4xl font-bold text-pink-600">Shop.dz 💄</a>
        <p class="text-gray-500 mt-2 text-sm">Connectez-vous à votre compte</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">

        {{-- Session Status --}}
        @if (session('status'))
            <div class="bg-green-100 text-green-700 rounded-lg px-4 py-3 mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="votre@email.com"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="text-sm font-semibold text-gray-700">Mot de passe</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-pink-600 hover:underline">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>
                <input type="password" name="password" required
                       placeholder="••••••••"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember"
                       class="w-4 h-4 accent-pink-600">
                <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-pink-700 transition">
                Se connecter
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-pink-600 font-semibold hover:underline">S'inscrire</a>
        </p>
    </div>
</div>

</body>
</html>