<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheep', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('date');
            $table->bigInteger('corral_id')->unsigned();
            $table->timestamps();
            $table->foreign('corral_id')
                ->references('id')
                ->on('corrals')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('sheeps');
    }
}
