<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        // Commandes du mois
        $delivered = Order::with('items.product')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'delivered')->get();

        $cancelled = Order::with('items.product')
            ->whereBetween('created_at', [$start, $end])
            ->where('status', 'cancelled')->get();

        $pending = Order::whereBetween('created_at', [$start, $end])
            ->whereIn('status', ['pending', 'processing', 'shipped'])->get();

        // Revenus (commandes livrées)
        $revenue   = $delivered->sum('total');
        $shipping  = $delivered->sum('shipping_price');

        // Coût d'achat des produits vendus
        $cost = 0;
        foreach ($delivered as $order) {
            foreach ($order->items as $item) {
                $cost += ($item->product->cost_price ?? 0) * $item->quantity;
            }
        }

        // Bénéfice = revenu produits + livraison - coût d'achat
        $profit = $revenue - $cost;

        // Pertes (commandes annulées — produits + coût)
        $lossRevenue = $cancelled->sum('total');
        $lossCost    = 0;
        foreach ($cancelled as $order) {
            foreach ($order->items as $item) {
                $lossCost += ($item->product->cost_price ?? 0) * $item->quantity;
            }
        }

        $stats = [
            'orders_count'     => $delivered->count(),
            'cancelled_count'  => $cancelled->count(),
            'pending_count'    => $pending->count(),
            'revenue'          => $revenue,
            'shipping_revenue' => $shipping,
            'cost'             => $cost,
            'profit'           => $profit,
            'loss_revenue'     => $lossRevenue,
            'loss_cost'        => $lossCost,
        ];

        // Liste des mois disponibles
        $availableMonths = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month")
            ->distinct()->orderByDesc('month')->pluck('month');

        if ($availableMonths->isEmpty()) {
            $availableMonths = collect([now()->format('Y-m')]);
        }

        return view('admin.stats.index', compact('stats', 'month', 'availableMonths', 'start'));
    }
}