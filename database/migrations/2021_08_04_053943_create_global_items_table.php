<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();

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

            $table->unique('model', 'brand');

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
        Schema::dropIfExists('global_items');
    }
}  
