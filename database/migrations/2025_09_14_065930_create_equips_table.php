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
        Schema::create('equips', function (Blueprint $table) {
            $table->id();
            $table->string('equip_name');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('add_by')->constrained('users')->onDelete('restrict'); // ห้ามลบ user ถ้ายังถูกอ้างอิง
            // FK อ้างอิง user ที่ลบ (nullable เพราะบาง record ยังไม่ถูกลบ)
            $table->foreignId('remove_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->timestamps();// created_at & updated_at
            $table->softDeletes();  // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equips');
    }
};
