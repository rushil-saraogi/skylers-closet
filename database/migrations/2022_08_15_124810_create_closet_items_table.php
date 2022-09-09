<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closet_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('closet_id');
            $table->unsignedBigInteger('item_id');
            $table->timestamps();

            $table->foreign('closet_id')
                ->references('id')
                ->on('closets')
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
        Schema::dropIfExists('closet_items');
    }
}
