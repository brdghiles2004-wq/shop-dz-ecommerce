<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | Shop.dz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💄</text></svg>">
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="text-4xl font-bold text-pink-600">Shop.dz 💄</a>
        <p class="text-gray-500 mt-2 text-sm">Créez votre compte gratuitement</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nom complet</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       placeholder="Votre nom"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="votre@email.com"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password" required
                       placeholder="••••••••"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required
                       placeholder="••••••••"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">
            </div>

            <button type="submit"
                    class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-pink-700 transition">
                Créer mon compte
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="text-pink-600 font-semibold hover:underline">Se connecter</a>
        </p>
    </div>
</div>

</body>
</html>