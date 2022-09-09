<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('closet_id');
            $table->unsignedBigInteger('global_item_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('item_order')->default(0); // 0 for no order

            // Item data
            $table->string('url')->nullable();
            $table->string('title')->nullable();
            $table->string('asin')->nullable();
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();

            $table->foreign('closet_id')
                ->references('id')
                ->on('closets')
                ->onDelete('cascade');
            
            $table->foreign('global_item_id')
                ->references('id')
                ->on('global_items')
                ->onDelete('cascade');
            
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::dropIfExists('links');
    }
}
