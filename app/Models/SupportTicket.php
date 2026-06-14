<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id', 'guest_email', 'name', 'subject',
        'message', 'status', 'admin_reply', 'replied_at'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'open'     => '🟡 En attente',
            'answered' => '🟢 Répondu',
            'closed'   => '🔴 Fermé',
            default    => $this->status,
        };
    }

    public function getClientNameAttribute()
    {
        return $this->user?->name ?? $this->name;
    }

    public function getClientEmailAttribute()
    {
        return $this->user?->email ?? $this->guest_email;
    }

    // ← zidha: wach kayen reply jdid lam yshofch client
    public function hasNewReply(): bool
    {
        if (!$this->admin_reply || !$this->replied_at) return false;
        if (!$this->user) return false;

        $lastSeen = $this->user->last_seen_support;
        if (!$lastSeen) return true;

        return $this->replied_at->gt($lastSeen);
    }
}