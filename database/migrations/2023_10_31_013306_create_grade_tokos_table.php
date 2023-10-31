<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeTokosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_tokos', function (Blueprint $table) {
            $table->id('id_grade_toko');
            $table->char('toko_id')->nullable();
            $table->string('grade_toko');
            $table->foreign('toko_id')->references('id_toko')->on('tokos')->onDelete('cascade');
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
        Schema::dropIfExists('grade_tokos');
    }
}
