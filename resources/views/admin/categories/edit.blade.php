@extends('layouts.app')
@section('title', 'Modifier catégorie')
@section('content')

<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm p-8">
    <h1 class="text-2xl font-bold mb-6">✏️ Modifier : {{ $category->name }}</h1>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('name') border-red-500 @enderror">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-pink-300 focus:outline-none">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-pink-600 text-white px-8 py-2 rounded-lg hover:bg-pink-700 font-bold">Sauvegarder</button>
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 text-gray-700">Annuler</a>
        </div>
    </form>
</div>

@endsection