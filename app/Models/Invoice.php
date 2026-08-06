<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'order_id',
        'invoice_number',
        'net_amount',
        'tax_amount',
        'gross_amount',
        'pdf_url',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
