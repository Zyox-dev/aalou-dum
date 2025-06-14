<?php

namespace App\Models;

use App\UuidGenerator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use UuidGenerator;

    protected $fillable = [
        'invoice_no',
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

    public static function generateInvoiceNo($companyName)
    {
        $businessCode = strtoupper(Str::substr($companyName, 0, 4)); // First 4 letters in uppercase
        $prefix = now()->format('Y-m'); // e.g. 2025-06

        $latestInvoice = self::where('invoice_no', 'like', "{$businessCode}/{$prefix}/%")
            ->orderByDesc('invoice_no')
            ->first();

        if ($latestInvoice) {
            $lastNumber = (int) Str::afterLast($latestInvoice->invoice_no, '/');
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$businessCode}/{$prefix}/{$newNumber}";
    }
}
