<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppDesignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_designs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('layout')->nullable();
            $table->string('theme')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('cover_image', 2048)->nullable();
            $table->string('logo', 2048)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_designs');
    }
}
