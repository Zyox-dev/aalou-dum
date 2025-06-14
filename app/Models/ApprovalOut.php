<?php

namespace App\Models;

use App\ApprovalType;
use App\UuidGenerator;
use Illuminate\Support\Facades\DB;
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
        'labour_id'
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

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }


    // Auto-generate serial number on create
    protected static function booted()
    {
        static::creating(function ($model) {
            $prefix = strtoupper(substr($model->approval_type_label, 0, 3)); // GOL, DIA, COL
            $yearMonth = now()->format('Y-m'); // e.g. "2025-06"

            DB::transaction(function () use ($model, $prefix, $yearMonth) {
                $tracker = ApprovalSerialTracker::lockForUpdate()->firstOrCreate([
                    'approval_type' => $model->approval_type,
                    'year_month' => $yearMonth,
                ]);

                $tracker->last_number += 1;
                $tracker->save();

                $serial = str_pad($tracker->last_number, 5, '0', STR_PAD_LEFT);
                $model->serial_no = "{$prefix}-{$yearMonth}-{$serial}";
            });
        });
    }
}
