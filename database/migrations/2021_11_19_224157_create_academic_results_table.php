<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("examine_id")->comment('Teacher\'s ID');
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger("student_class_id");
            $table->integer('serial');
            $table->unsignedBigInteger("subject_id");
            $table->float('marks');
            $table->char('gpa');
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
        Schema::dropIfExists('academic_results');
    }
}
