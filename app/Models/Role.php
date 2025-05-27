<?php

namespace App\Models;

use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use UuidGenerator;

    protected $fillable = ['name','display_name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
