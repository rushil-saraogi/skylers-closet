<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawer_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drawer_id');
            $table->unsignedBigInteger('item_id');
            $table->timestamps();

            $table->foreign('drawer_id')
                ->references('id')
                ->on('drawers')
                ->onDelete('cascade');

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drawer_items');
    }
}
