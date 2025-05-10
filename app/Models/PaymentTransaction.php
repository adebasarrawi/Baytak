<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'status'
    ];

    /**
     * Get the user that owns the payment transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}