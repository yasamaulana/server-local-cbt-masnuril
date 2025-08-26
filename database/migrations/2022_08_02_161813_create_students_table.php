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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->references('id')->on('classrooms')->cascadeOnDelete();
            $table->foreignId('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->string('nisn')->unique();
            $table->string('name');
            $table->enum('ketua_kelas', ['1', '2'])->default(1);
            $table->string('password');
            $table->enum('gender', ['L', 'P'])->default('L');
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
        Schema::dropIfExists('students');
    }
};