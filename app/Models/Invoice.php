<?php

namespace App\Models;

use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use UuidGenerator;

    protected $fillable = [
        'customer_name',
        'customer_address',
        'customer_gstin',
        'customer_pan',
        'purchase_date',
        'cgst_percent',
        'sgst_percent',
        'igst_percent',
        'subtotal_amount',
        'gst_amount',
        'total_amount',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
