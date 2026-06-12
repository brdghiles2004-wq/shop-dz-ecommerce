<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function identifier(): array
    {
        return Auth::check()
            ? ['user_id' => Auth::id()]
            : ['session_id' => session()->getId()];
    }

    public function index()
    {
        $cartItems = Cart::where($this->identifier())->with('product')->get();
        $total = $cartItems->sum(fn($i) => $i->product->final_price * $i->quantity);
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'integer|min:1',
        ]);

        $identifier = $this->identifier();
        $cart = Cart::where($identifier)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $cart->increment('quantity', $request->input('quantity', 1));
        } else {
            Cart::create(array_merge($identifier, [
                'product_id' => $request->product_id,
                'quantity'   => $request->input('quantity', 1),
            ]));
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    public function update(Request $request, Cart $cart)
    {
        $cart->update(['quantity' => max(1, (int) $request->quantity)]);
        return redirect()->back();
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return redirect()->back()->with('success', 'Produit supprimé du panier.');
    }
}