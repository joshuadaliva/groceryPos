<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'total_amount',
        'amount_paid',
        'change_amount',
        'payment_status',
        'sale_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'sale_date' => 'datetime',
    ];

    // Relationship with users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with sales_details
    public function saleDetails()
    {
        return $this->hasMany(SalesDetail::class, 'sale_id');
    }

    // Generate unique invoice number
    public static function generateInvoiceNumber()
    {
        $lastSale = Sale::latest('id')->first();
        $nextNumber = ($lastSale ? $lastSale->id : 0) + 1;
        return 'INV-' . date('Ymd') . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
