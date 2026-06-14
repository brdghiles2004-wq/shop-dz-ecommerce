<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::latest()->paginate(20);
        return view('admin.support.index', compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        return view('admin.support.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:2000',
            'status'      => 'required|in:open,answered,closed',
        ]);

        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'status'      => $request->status,
            'replied_at'  => now(),
        ]);

        return redirect()->route('admin.support.index')
            ->with('success', 'Réponse envoyée !');
    }
}