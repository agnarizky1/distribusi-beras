<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembaliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id('id_pengembalian');
            $table->char('kode_pengembalian');
            $table->char('id_toko');
            $table->date('tanggal_pengembalian');
            $table->integer('jumlah_return');
            $table->integer('uang_return');
            $table->timestamps();

            $table->foreign('id_toko')->references('id_toko')->on('tokos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalians');
    }
}
