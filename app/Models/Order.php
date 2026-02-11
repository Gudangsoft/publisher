<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
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
        $labels = [
            'pending' => 'Pending',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
            'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
            'shipped' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
            'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
        ];
        return $colors[$this->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
    }

    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }
}
