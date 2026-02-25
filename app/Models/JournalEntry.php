<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
   protected $fillable = [
        'sale_id',
        'account_id',
        'debit',
        'credit',
        'entry_date'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
