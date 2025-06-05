<?php

namespace App\Models;

use App\UuidGenerator;
use App\LedgerEntryType;
use App\MaterialType;
use Illuminate\Database\Eloquent\Model;

class MaterialLedger extends Model
{
    use UuidGenerator;


    protected $fillable = [
        'date',
        'material_type',
        'entry_type',
        'quantity',
        'labour_id',
        'reference_id',
        'remarks',
    ];

    protected $casts = [
        'material_type' => MaterialType::class,
        'entry_type' => LedgerEntryType::class,
    ];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }
}
