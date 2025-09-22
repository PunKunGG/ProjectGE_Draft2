<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public const STATUS_OPTIONS = [
        'Available' => 'พร้อมใช้งาน',
        'Borrowed' => 'ยืมแล้ว',
        'Pending Return' => 'รอดำเนินการคืน',
        'Unavailable' => 'ไม่พร้อมใช้งาน',
        'Maintenance' => 'ซ่อมบำรุง',
        'Lost' => 'สูญหาย',
    ];

    protected $fillable = [
        'equip_id',
        'asset_code',
        'status',
        'created_by',
    ];

    public function equip()
    {
        return $this->belongsTo(Equip::class);
    }
}
