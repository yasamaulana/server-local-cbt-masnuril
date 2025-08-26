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
        Schema::create('keterserapan', function (Blueprint $table) {
            $table->id();
            $table->string('program_keahlian');
            $table->integer('jumlah_laki_laki');
            $table->integer('jumlah_perempuan');
            $table->integer('bekerja');
            $table->integer('kuliah');
            $table->integer('usaha');
            $table->integer('jumlah')->nullable();
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
        Schema::dropIfExists('keterserapan');
    }
};
