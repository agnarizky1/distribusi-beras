<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailDistribusiTable extends Migration
{
    public function up()
    {
        Schema::create('detail_distribusi', function (Blueprint $table) {
            $table->id('id_detail_distribusi');
            $table->unsignedBigInteger('id_distribusi');
            $table->string('nama_beras');
            $table->integer('harga');
            $table->integer('jumlah_beras');
            $table->integer('sub_total');
            $table->timestamps();

            $table->foreign('id_distribusi')->references('id_distribusi')->on('distribusis');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_distribusi');
    }
}
