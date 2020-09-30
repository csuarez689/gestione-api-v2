<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools_teachers', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('division');
            $table->string('subject');
            $table->smallInteger('monthly_hours');
            $table->string('teacher_title');
            $table->string('teacher_category_title');

            $table->foreignId('school_id')->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->onDelete('set null');
            $table->foreignId('job_state_id');

            $table->unique(['year', 'division', 'subject', 'school_id']);

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
        Schema::dropIfExists('schools_teachers');
    }
}
