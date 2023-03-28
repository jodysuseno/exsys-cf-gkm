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
        Schema::create('basis_pengetahuans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kasus_id');
            $table->unsignedBigInteger('gejala_id');
            $table->unsignedBigInteger('bobot_gejala_id');
            $table->foreign('kasus_id')->references('id')->on('kasuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('gejala_id')->references('id')->on('gejalas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bobot_gejala_id')->references('id')->on('bobot_gejalas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('basis_pengetahuans');
    }
};
