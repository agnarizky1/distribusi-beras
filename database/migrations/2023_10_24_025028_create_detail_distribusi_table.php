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
            $table->string('jenis_beras');
            $table->decimal('harga', 10, 2);
            $table->decimal('jumlah_beras', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->timestamps();

            $table->foreign('id_distribusi')->references('id_distribusi')->on('distribusis');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_distribusi');
    }
}
