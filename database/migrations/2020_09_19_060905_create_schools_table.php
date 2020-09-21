<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cue');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('internal_phone')->nullable();
            $table->string('email')->unique();
            $table->integer('number_students')->nullable();
            $table->boolean('bilingual');
            $table->string('director');
            $table->string('orientation');
            $table->timestamps();

            $table->foreignId('ambit_id')->constrained('school_ambits');

            $table->foreignId('sector_id')->constrained('school_sectors');

            $table->foreignId('type_id')->constrained('school_types');

            $table->foreignId('level_id')->constrained('school_levels');

            $table->foreignId('category_id')->constrained('school_categories');

            $table->foreignId('journey_type_id')->constrained('journey_types');

            $table->foreignId('locality_id')->constrained('localities');

            $table->foreignId('high_school_type_id')->nullable()->constrained('high_school_types');

            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->onDelete('set null');

            $table->unique(['cue', 'level_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
