<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pengembalians', function (Blueprint $table) {
            $table->id('id_detail_pengembalian');
            $table->unsignedBigInteger('id_pengembalian');
            $table->unsignedBigInteger('id_detail_distribusi');
            $table->string('nama_baras');
            $table->string('jenis_baras');
            $table->integer('harga');
            $table->integer('sub_total');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('id_pengembalian')->references('id_pengembalian')->on('pengembalians');
            $table->foreign('id_detail_distribusi')->references('id_detail_distribusi')->on('detail_distribusi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pengembalians');
    }
}
