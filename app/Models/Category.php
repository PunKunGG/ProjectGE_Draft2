<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth; 

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function equips()
    {
        return $this->hasMany(Equip::class);
    }

    protected $fillable = [
        'name',
        'created_by', // <-- เพิ่ม 'created_by'
        'deleted_by'
    ];

     protected static function boot()
    {
        parent::boot();

        // Event: Fired just before a record is "soft deleted".
        static::deleting(function ($category) {
            // Check if a user is authenticated
            if (Auth::check()) {
                $category->deleted_by = Auth::id();
                $category->save();
            }
        });
    }
}
