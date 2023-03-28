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
        Schema::create('basis_pengetahuan_kompleksitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kasus_id');
            $table->unsignedBigInteger('kompleksitas_id');
            $table->foreign('kasus_id')->references('id')->on('kasuses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kompleksitas_id')->references('id')->on('bobot_kompleksitas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('basis_pengetahuan_kompleksitas');
    }
};
