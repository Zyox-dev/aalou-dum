<?php

namespace App\Models;

use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Labour extends Model
{
    use UuidGenerator;
    protected $fillable = ['name', 'mobile'];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }
}
