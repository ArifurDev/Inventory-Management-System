<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
   protected $fillable = [
        'sale_date',
        'subtotal',
        'discount',
        'vat',
        'total_amount',
        'paid_amount',
        'due_amount'
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class);
    }
}
