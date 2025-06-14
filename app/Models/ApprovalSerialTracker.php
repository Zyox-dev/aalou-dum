<?php

namespace App\Models;

use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class ApprovalSerialTracker extends Model
{
    use UuidGenerator;
    protected $fillable = ['approval_type', 'year_month', 'last_number'];
}
