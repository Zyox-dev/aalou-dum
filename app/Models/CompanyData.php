<?php

namespace App\Models;

use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyData extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyDataFactory> */
    use HasFactory, UuidGenerator;


    protected $table = 'company_data';

    protected $guarded = [];

    protected $casts = [
        'admin_cost_percent' => 'float',
        'margin_percent' => 'float',
    ];
}
