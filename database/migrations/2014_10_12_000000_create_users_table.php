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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('telp', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->text('alamat')->nullable();
            $table->string('password');
            $table->string('token_forgot_password')->nullable();
            $table->integer('status')->unsigned();
            $table->string('nim', 20)->unique();
            $table->integer('angkatan')->unsigned();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
