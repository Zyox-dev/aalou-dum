<?php

namespace App\Models;

use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, UuidGenerator;

    protected $fillable = [
        'product_no',
        'name',

        'gold_qty',
        'gold_rate',
        'gold_total',

        'diamond_qty',
        'diamond_rate',
        'diamond_total',

        'color_stone_qty',
        'color_stone_rate',
        'color_stone_total',

        'labour_count',
        'labour_rate',
        'labour_total',

        'total_amount',
        'gross_amount',
        'mrp',

        'description',
        'show_in_frontend',
        'gold_carat',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $lastNumber = (int) self::max(DB::raw('CAST(product_no AS UNSIGNED)')) + 1;
            $model->product_no = str_pad($lastNumber, 6, '0', STR_PAD_LEFT);
        });
    }
}
