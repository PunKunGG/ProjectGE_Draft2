<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function arrows()
    {
        return $this->hasMany(Arrow::class);
    }

    public function session(){
        return $this->belongsTo(session::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
