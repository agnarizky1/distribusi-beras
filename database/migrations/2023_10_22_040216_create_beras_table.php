<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beras', function (Blueprint $table) {
            $table->char('id_beras',30)->primary();
            $table->string('merk_beras');
            $table->string('berat');
            $table->string('nama_sopir');
            $table->string('plat_no');
            $table->date('tanggal_masuk_beras');
            $table->integer('harga');
            $table->integer('stock');
            $table->enum('keterangan',['Beras Return', 'Dari Pabrik'])->default('Dari Pabrik');
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
        Schema::dropIfExists('beras');
    }
}
