<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokos', function (Blueprint $table) {
            $table->char('id_toko',30)->primary();
            $table->string('foto_toko');
            $table->string('nama_toko');
            $table->string('sales');
            $table->string('grade_toko');
            $table->string('pemilik');
            $table->string('foto_ktp');
            $table->string('alamat');
            $table->string('nomor_tlp');
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
        Schema::dropIfExists('tokos');
    }
}
