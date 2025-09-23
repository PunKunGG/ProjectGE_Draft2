<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipLoan extends Model
{
    use HasFactory;

     public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'user_id',
        'item_id',
        'due_date',
        'returned_at',
        'notes',
        'pending_return_at',
        'return_photo_path'
    ];
}
