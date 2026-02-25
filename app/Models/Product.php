<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'purchase_price',
        'sell_price',
        'stock_quantity'
    ];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
