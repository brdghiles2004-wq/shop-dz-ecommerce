<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'    => Order::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'total_products'  => Product::count(),
            'total_users'     => User::where('is_admin', false)->count(),
            'revenue'         => Order::where('status', 'delivered')->sum('total'),
            'new_users_today' => User::where('is_admin', false)
                                    ->whereDate('created_at', today())
                                    ->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}