<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->unsignedBigInteger('published_app_design_id')->nullable();
            $table->unsignedBigInteger('draft_app_design_id')->nullable();
            $table->timestamps();

            $table->foreign('published_app_design_id')
                ->references('id')
                ->on('app_designs')
                ->onDelete('cascade');
            
            $table->foreign('draft_app_design_id')
                ->references('id')
                ->on('app_designs')
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
        Schema::dropIfExists('hotels');
    }
}
