<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik');
            $table->string('nisn');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->string('asal_sekolah');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('nama_ayah');
            $table->text('alamat_ayah');
            $table->string('nik_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('nama_ibu');
            $table->text('alamat_ibu');
            $table->string('nik_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('kk');
            $table->string('ktp_ayah');
            $table->string('ktp_ibu');
            $table->string('kip')->nullable();
            $table->string('kks')->nullable();
            $table->string('ijazah');
            $table->string('rekomendasi')->nullable();
            $table->enum('status', ['Menunggu Verifikasi', 'Diterima', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
