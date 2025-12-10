<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'product_category',
        'product_image',
        'price',
        'stock_quantity',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    // Relationship with sales_details
    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class, 'product_id');
    }

    // Relationship with stock_logs
    public function stockLogs()
    {
        return $this->hasMany(StockLog::class, 'product_id');
    }

    // Check if product is low stock (below 5)
    public function isLowStock()
    {
        return $this->stock_quantity < 5;
    }

    // Add stock
    public function addStock($quantity, $reference = null)
    {
        $this->stock_quantity += $quantity;
        $this->save();

        StockLog::create([
            'product_id' => $this->id,
            'change_type' => 'in',
            'quantity' => $quantity,
            'reference' => $reference,
        ]);
    }

    // Deduct stock (for sales)
    public function deductStock($quantity, $reference = null)
    {
        if ($this->stock_quantity >= $quantity) {
            $this->stock_quantity -= $quantity;
            $this->save();

            StockLog::create([
                'product_id' => $this->id,
                'change_type' => 'out',
                'quantity' => $quantity,
                'reference' => $reference,
            ]);

            return true;
        }

        return false;
    }
}
