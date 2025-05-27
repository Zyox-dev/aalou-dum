<?php

namespace App\Models;

use App\ApprovalType;
use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class ApprovalOut extends Model
{
    use UuidGenerator;


    protected $fillable = [
        'serial_no',
        'approval_type',
        'date',
        'rate',
        'qty',
        'gst_percent',
    ];

    protected $casts = [
        'approval_type' => ApprovalType::class, // treat enum as string for now
        'date' => 'date',
    ];

    protected $appends = ['approval_type_label'];

    public function getApprovalTypeLabelAttribute()
    {
        return ApprovalType::from($this->approval_type->value)->label();
    }

    // Auto-generate serial number on create
    protected static function booted()
    {
        static::creating(function ($model) {
            $prefix = strtoupper(substr($model->approval_type_label, 0, 3)); // GOL, DIA, COL
            $year = now()->format('Y');
            $month = now()->format('m');

            // Count existing records for same type, year, and month
            $count = static::where('approval_type', $model->approval_type)
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count() + 1;

            $model->serial_no = "{$prefix}-{$year}-{$month}-" . str_pad($count, 5, '0', STR_PAD_LEFT);
        });
    }
}
