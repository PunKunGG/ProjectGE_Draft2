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
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // ห้ามลบ user ถ้ายังถูกอ้างอิง
            $table->foreignId('session_id')->constrained('sessions')->onDelete('restrict'); // ห้ามลบ session ถ้ายังถูกอ้างอิง
            $table->integer('round_number');
            $table->integer('distance');
            $table->integer('arrow_quantity');
            $table->enum('bow_type',['Recurve','Barebow'])->default('Barebow');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rounds');
    }
};
