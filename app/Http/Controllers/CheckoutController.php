<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wilaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    private function getCartItems()
    {
        $identifier = Auth::check()
            ? ['user_id' => Auth::id()]
            : ['session_id' => session()->getId()];

        return Cart::where($identifier)->with('product')->get();
    }

    public function index()
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $wilayas = Wilaya::orderBy('name')->get();
        $total   = $cartItems->sum(fn($i) => $i->product->final_price * $i->quantity);

        return view('checkout.index', compact('cartItems', 'total', 'wilayas'));
    }

    public function store(Request $request)
    {
        $rules = [
            'shipping_name'    => 'required|string|max:100',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_city'    => 'required|string|max:100',
            'wilaya_id'        => 'required|exists:wilayas,id',
            'delivery_type'    => 'required|in:stopdesk,home',
            'notes'            => 'nullable|string|max:500',
            'shipping_address' => 'required_if:delivery_type,home|nullable|string',
        ];

        // ida guest — email obligatoire
        if (!Auth::check()) {
            $rules['guest_email'] = 'required|email';
        }

        $messages = [
            'shipping_name.required'    => 'Le nom complet est obligatoire.',
            'shipping_phone.required'   => 'Le numéro de téléphone est obligatoire.',
            'shipping_city.required'    => 'La ville est obligatoire.',
            'wilaya_id.required'        => 'Veuillez choisir une wilaya.',
            'delivery_type.required'    => 'Veuillez choisir un type de livraison.',
            'shipping_address.required_if' => 'L\'adresse est obligatoire pour la livraison à domicile.',
            'guest_email.required'      => 'L\'email est obligatoire.',
            'guest_email.email'         => 'L\'email n\'est pas valide.',
        ];

        $request->validate($rules, $messages);

        $cartItems = $this->getCartItems();
        if ($cartItems->isEmpty()) return redirect()->route('cart.index');

        $wilaya   = Wilaya::findOrFail($request->wilaya_id);
        $subtotal = $cartItems->sum(fn($i) => $i->product->final_price * $i->quantity);

        $shippingPrice = $request->delivery_type === 'home'
            ? $wilaya->home_price
            : $wilaya->stopdesk_price;

        $total = $subtotal + $shippingPrice;

        $order = Order::create([
            'user_id'          => Auth::check() ? Auth::id() : null,
            'guest_email'      => Auth::check() ? null : $request->guest_email,
            'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
            'total'            => $total,
            'shipping_price'   => $shippingPrice,
            'status'           => 'pending',
            'delivery_type'    => $request->delivery_type,
            'shipping_name'    => $request->shipping_name,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address ?? 'Stop Desk',
            'shipping_city'    => $request->shipping_city,
            'wilaya'           => $wilaya->name,
            'notes'            => $request->notes,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->final_price,
            ]);
            $item->product->decrement('stock', $item->quantity);
        }

        // vider panier
        $identifier = Auth::check()
            ? ['user_id' => Auth::id()]
            : ['session_id' => session()->getId()];
        Cart::where($identifier)->delete();

        // guest → page confirmation simple
        if (!Auth::check()) {
            return redirect()->route('home')
                ->with('success', 'Commande passée ! Numéro: ' . $order->order_number . ' — Gardez ce numéro pour suivre votre commande.');
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Commande passée ! Numéro: ' . $order->order_number);
    }
}