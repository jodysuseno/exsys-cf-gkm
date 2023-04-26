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
        Schema::create('kasuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('penyakit_id');
            $table->float('similarity');
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('penyakit_id')->references('id')->on('penyakits')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['reuse','revise']);
            $table->enum('keterangan', ['selesai','tunggu']);
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
        Schema::dropIfExists('kasuses');
    }
};
