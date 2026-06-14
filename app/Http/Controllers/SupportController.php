<?php
namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
{
    $tickets = null;
    if (Auth::check()) {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->latest()->get();

        // reset notification
        Auth::user()->update(['last_seen_support' => now()]);
    }
    return view('support.index', compact('tickets'));
}

    public function store(Request $request)
    {
        $rules = [
            'name'    => 'required|string|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ];

        if (!Auth::check()) {
            $rules['guest_email'] = 'required|email';
        }

        $request->validate($rules);

        SupportTicket::create([
            'user_id'     => Auth::check() ? Auth::id() : null,
            'guest_email' => Auth::check() ? null : $request->guest_email,
            'name'        => $request->name,
            'subject'     => $request->subject,
            'message'     => $request->message,
            'status'      => 'open',
        ]);

        return redirect()->route('support.index')
            ->with('success', 'Votre message a été envoyé ! Nous vous répondrons bientôt.');
    }

    public function show(SupportTicket $ticket)
    {
        if (Auth::check() && $ticket->user_id !== Auth::id()) {
            abort(403);
        }
        return view('support.show', compact('ticket'));
    }
}