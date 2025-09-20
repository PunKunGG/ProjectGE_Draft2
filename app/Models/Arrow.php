<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Arrow extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function round()
    {
        return $this->belongsTo(Round::class);
    }
}
