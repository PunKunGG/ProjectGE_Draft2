<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equip_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // ห้ามลบ user ถ้ายังถูกอ้างอิง
            $table->foreignId('item_id')->constrained('items');
            $table->text('notes')->nullable();
            $table->timestamp('due_date');
            $table->timestamp('pending_return_at')->nullable(); // วันที่ member กดแจ้งคืน
            $table->string('return_photo_path')->nullable(); // ที่อยู่ของไฟล์รูป
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equip_loans');
    }
};
