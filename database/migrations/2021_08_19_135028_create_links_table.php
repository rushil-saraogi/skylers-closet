<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('url');
            $table->string('name');
            $table->string('color');
            $table->string('icon');
            $table->boolean('animated')->default(false);
            $table->string('title')->nullable();
            $table->string('og_title')->nullable();
            $table->string('description')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
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
