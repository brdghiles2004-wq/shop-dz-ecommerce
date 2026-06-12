<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
   

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $total = $cartItems->sum(fn($i) => $i->product->final_price * $i->quantity);

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name'    => 'required|string|max:100',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city'    => 'required|string|max:100',
            'wilaya'           => 'required|string|max:100',
            'notes'            => 'nullable|string|max:500',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $total = $cartItems->sum(fn($i) => $i->product->final_price * $i->quantity);

        $order = Order::create([
            'user_id'          => Auth::id(),
            'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
            'total'            => $total,
            'status'           => 'pending',
            'shipping_name'    => $request->shipping_name,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city'    => $request->shipping_city,
            'wilaya'           => $request->wilaya,
            'notes'            => $request->notes,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->final_price,
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Commande passée avec succès ! Numéro: ' . $order->order_number);
    }
}