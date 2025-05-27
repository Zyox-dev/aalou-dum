<?php

namespace App\Models;

use App\UuidGenerator;
use App\PurchaseType;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use UuidGenerator;
    protected $fillable = [
        'purchase_type',
        'rate_per_unit',
        'karrot',
        'weight_in_gram',
        'amount_total',
        'gst_percent',
        'purchase_date',
        'color_stone_name',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'purchase_type' => PurchaseType::class,
    ];

    protected $appends = ['purchase_type_label'];

    public function getPurchaseTypeLabelAttribute()
    {
        return PurchaseType::from($this->purchase_type->value)->label();
    }
}
