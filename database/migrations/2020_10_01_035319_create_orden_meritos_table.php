<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenMeritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_meritos', function (Blueprint $table) {
            $table->id();
            $table->string('incumbency')->nullable();
            $table->string('region');
            $table->string('level');
            $table->string('last_name');
            $table->string('name');
            $table->string('cuil');
            $table->string('gender');
            $table->string('locality');
            $table->string('charge');
            $table->string('title1');
            $table->string('title2')->nullable();
            $table->string('year');

            $table->unique(['year', 'cuil', 'charge']);

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
        Schema::dropIfExists('orden_meritos');
    }
}
