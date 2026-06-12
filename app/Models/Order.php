<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'total', 'status',
        'shipping_name', 'shipping_phone', 'shipping_address',
        'shipping_city', 'wilaya', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending'    => '⏳ En attente',
            'processing' => '⚙️ En traitement',
            'shipped'    => '🚚 Expédiée',
            'delivered'  => '✅ Livrée',
            'cancelled'  => '❌ Annulée',
            default      => $this->status,
        };
    }
}