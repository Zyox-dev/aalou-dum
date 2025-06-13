<?php

namespace App\Models;

use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use UuidGenerator;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_code',
        'product_name',
        'quantity',
        'rate',
        'total',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
