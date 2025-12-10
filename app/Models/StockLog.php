<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $table = 'stock_logs';

    protected $fillable = [
        'product_id',
        'change_type',
        'quantity',
        'reference',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationship with product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
