<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 

class Equip extends Model
{
    use HasFactory;

    use SoftDeletes;

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'add_by');
    }

    public function removedBy()
    {
        return $this->belongsTo(User::class, 'remove_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'equip_id');
    }

    protected $fillable = [
        'equip_name',
        'category_id',
        'add_by',
        'remove_by',
    ];

     protected static function boot()
    {
        parent::boot();

        // Event: Fired just before a record is "soft deleted".
        static::deleting(function ($equip) {
            // Check if a user is authenticated
            if (Auth::check()) {
                $equip->remove_by = Auth::id();
                $equip->save();
            }
        });
    }


}
