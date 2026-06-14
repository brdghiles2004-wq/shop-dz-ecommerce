@extends('layouts.app')
@section('title', ' Commander | Shop.dz')
@section('content')

<h1 class="text-2xl font-bold mb-6">📦 Finaliser la commande</h1>

<div class="grid md:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-bold mb-4">Informations de livraison</h2>
        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Email guest uniquement --}}
            @guest
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email (pour confirmation)</label>
                <input type="email" name="guest_email" value="{{ old('guest_email') }}"
                       placeholder="votre@email.com"
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('guest_email') border-red-500 ring-2 ring-red-100 @enderror">
                @error('guest_email')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                @enderror
            </div>
            @endguest

            {{-- Nom --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                <input type="text" name="shipping_name"
                       value="{{ old('shipping_name', auth()->user()->name ?? '') }}"
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('shipping_name') border-red-500 ring-2 ring-red-100 @enderror">
                @error('shipping_name')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Téléphone --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <div class="flex">
                    <span class="bg-gray-100 border border-r-0 rounded-l-xl px-4 py-3 text-gray-600 font-medium text-sm">+213</span>
                    <input type="text" name="shipping_phone" value="{{ old('shipping_phone') }}"
                           placeholder="0XXXXXXXXX"
                           class="flex-1 border rounded-r-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('shipping_phone') border-red-500 ring-2 ring-red-100 @enderror">
                </div>
                @error('shipping_phone')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Wilaya --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Wilaya</label>
                <select name="wilaya_id" id="wilaya_select"
                        class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('wilaya_id') border-red-500 ring-2 ring-red-100 @enderror"
                        onchange="updatePrices()">
                    <option value="">-- Choisir votre wilaya --</option>
                    @foreach($wilayas as $w)
                    <option value="{{ $w->id }}"
                            data-stopdesk="{{ $w->stopdesk_price }}"
                            data-home="{{ $w->home_price }}"
                            {{ old('wilaya_id') == $w->id ? 'selected' : '' }}>
                        {{ $w->name }}
                    </option>
                    @endforeach
                </select>
                @error('wilaya_id')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Type livraison --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type de livraison</label>
                <div class="grid grid-cols-2 gap-3">
                    <label id="label_stopdesk"
                           class="border-2 border-pink-500 bg-pink-50 rounded-xl p-4 cursor-pointer transition">
                        <input type="radio" name="delivery_type" value="stopdesk" class="hidden" checked>
                        <p class="font-bold text-gray-800 text-sm">🏪 Stop Desk</p>
                        <p class="text-xs text-gray-500 mt-1">Retrait au bureau</p>
                        <p id="price_stopdesk" class="text-pink-600 font-bold mt-2 text-sm">—</p>
                    </label>
                    <label id="label_home"
                           class="border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-pink-300 transition">
                        <input type="radio" name="delivery_type" value="home" class="hidden">
                        <p class="font-bold text-gray-800 text-sm">🏠 À domicile</p>
                        <p class="text-xs text-gray-500 mt-1">Livraison chez vous</p>
                        <p id="price_home" class="text-pink-600 font-bold mt-2 text-sm">—</p>
                    </label>
                </div>
                @error('delivery_type')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Ville --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ville / Commune</label>
                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}"
                       placeholder="Ex: Tizi Ouzou centre"
                       class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('shipping_city') border-red-500 ring-2 ring-red-100 @enderror">
                @error('shipping_city')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Adresse (yban ghi ida home) --}}
            <div id="address_section" style="display:none">
                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse complète</label>
                <textarea name="shipping_address" rows="2"
                          placeholder="Rue, quartier, numéro..."
                          class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none @error('shipping_address') border-red-500 ring-2 ring-red-100 @enderror">{{ old('shipping_address') }}</textarea>
                @error('shipping_address')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optionnel)</label>
                <textarea name="notes" rows="2" placeholder="Instructions spéciales..."
                          class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-pink-300 focus:outline-none">{{ old('notes') }}</textarea>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <p class="text-red-600 text-sm font-bold mb-1">⚠️ Veuillez corriger les erreurs ci-dessus :</p>
                    <ul class="text-red-500 text-xs list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit"
                    class="w-full bg-pink-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-pink-700 transition">
                ✅ Confirmer la commande
            </button>
        </form>
    </div>

    {{-- Récapitulatif --}}
    <div class="bg-white rounded-xl shadow-sm p-6 h-fit sticky top-20">
        <h2 class="text-lg font-bold mb-4">Récapitulatif</h2>

        @foreach($cartItems as $item)
        <div class="flex justify-between text-sm py-2 border-b last:border-0">
            <span class="text-gray-700">{{ $item->product->name }} × {{ $item->quantity }}</span>
            <span class="font-bold">{{ number_format($item->product->final_price * $item->quantity, 0) }} DA</span>
        </div>
        @endforeach

        <div class="mt-4 space-y-2 text-sm">
            <div class="flex justify-between text-gray-600">
                <span>Sous-total</span>
                <span>{{ number_format($total, 0) }} DA</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Livraison</span>
                <span id="shipping_display" class="font-medium text-gray-400">Choisir wilaya</span>
            </div>
            <div class="flex justify-between font-bold text-lg pt-2 border-t text-pink-600">
                <span>Total</span>
                <span id="total_display">{{ number_format($total, 0) }} DA</span>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-4 text-center">💳 Paiement à la livraison (Cash)</p>
    </div>
</div>

<script>
const subtotal = {{ $total }};
let selectedType = 'stopdesk';

function selectDelivery(type) {
    selectedType = type;

    ['home', 'stopdesk'].forEach(t => {
        document.getElementById('label_' + t).classList.remove('border-pink-500', 'bg-pink-50');
        document.getElementById('label_' + t).classList.add('border-gray-200');
    });

    document.getElementById('label_' + type).classList.add('border-pink-500', 'bg-pink-50');
    document.getElementById('label_' + type).classList.remove('border-gray-200');

    document.getElementById('address_section').style.display =
        type === 'home' ? 'block' : 'none';

    updateTotal();
}

function updatePrices() {
    const select = document.getElementById('wilaya_select');
    const option = select.options[select.selectedIndex];
    if (!option.value) return;

    const stopdesk = parseFloat(option.dataset.stopdesk);
    const home     = parseFloat(option.dataset.home);

    document.getElementById('price_stopdesk').textContent =
        stopdesk === 0 ? '🎁 Gratuit' : stopdesk.toLocaleString() + ' DA';
    document.getElementById('price_home').textContent =
        home === 0 ? '🎁 Gratuit' : home.toLocaleString() + ' DA';

    updateTotal();
}

function updateTotal() {
    const select = document.getElementById('wilaya_select');
    const option = select.options[select.selectedIndex];
    if (!option.value) return;

    const price = selectedType === 'home'
        ? parseFloat(option.dataset.home)
        : parseFloat(option.dataset.stopdesk);

    document.getElementById('shipping_display').textContent =
        price === 0 ? '🎁 Gratuit' : price.toLocaleString() + ' DA';
    document.getElementById('total_display').textContent =
        (subtotal + price).toLocaleString() + ' DA';
}

document.getElementById('label_stopdesk').addEventListener('click', () => selectDelivery('stopdesk'));
document.getElementById('label_home').addEventListener('click', () => selectDelivery('home'));

selectDelivery('stopdesk');
</script>

@endsection