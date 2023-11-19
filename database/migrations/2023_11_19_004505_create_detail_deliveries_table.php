<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_deliveries', function (Blueprint $table) {
            $table->id('id_detail_delivery');
            $table->unsignedBigInteger('id_delivery');
            $table->unsignedBigInteger('id_distribusi');
            $table->timestamps();

            $table->foreign('id_delivery')->references('id_delivery')->on('delivery_orders')->onDelete('cascade');
            $table->foreign('id_distribusi')->references('id_distribusi')->on('distribusis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_deliveries');
    }
}
