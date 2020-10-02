<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedOrdenMeritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_orden_meritos', function (Blueprint $table) {
            $table->id();
            $table->string('incumbency')->nullable();
            $table->string('region')->nullable();
            $table->string('level')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('cuil')->nullable();
            $table->string('gender')->nullable();
            $table->string('locality')->nullable();
            $table->string('charge')->nullable();
            $table->string('title1')->nullable();
            $table->string('title2')->nullable();
            $table->string('year')->nullable();
            $table->string('errors')->nullable();

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
        Schema::dropIfExists('failed_orden_meritos');
    }
}
