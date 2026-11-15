<?php

namespace App\Modules\Order\app\Models;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'delivery_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function ($order) {
            $date = now()->format('Ymd');

            $order->order_number = 'ORD-' . $date . '-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);

            $order->save();
        });
    }

    public function orderDetails(): HasMany
    {
        return  $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Transaction::class, 'order_id');
    }
}
