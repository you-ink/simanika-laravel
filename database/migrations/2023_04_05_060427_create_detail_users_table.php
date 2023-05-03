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
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('bukti_kesanggupan')->nullable();
            $table->string('bukti_mahasiswa')->nullable();
            $table->date('tanggal_wawancara')->nullable();
            $table->time('waktu_wawancara')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('divisi_id')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('divisi_id')->references('id')->on('divisis')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_users');
    }
};
