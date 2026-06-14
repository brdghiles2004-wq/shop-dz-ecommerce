<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->latest()->take(5)->get();

        return view('profile.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Profil mis à jour avec succès !');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.index')
                ->with('error_password', 'Mot de passe actuel incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Mot de passe modifié avec succès !');
    }
}