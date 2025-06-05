<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\UuidGenerator;

class ProductImage extends Model
{
    use HasFactory, UuidGenerator;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['product_id', 'image_path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
