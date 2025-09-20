<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EquipLoan extends Model
{
    use HasFactory;
    use SoftDeletes;

     public function equip()
    {
        return $this->belongsTo(Equip::class, 'equip_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
