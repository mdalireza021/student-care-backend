<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string("id_no")->nullable();
            $table->string("school_id")->nullable();
            $table->string("phone")->nullable();
            $table->string("roll_number")->nullable();
            $table->unsignedInteger("student_class_id");
            $table->unsignedBigInteger("section_id");
            $table->unsignedBigInteger("shift_id")->nullable();
            $table->char("gender")->nullable();
            $table->char("blood_type")->nullable();
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
        Schema::dropIfExists('students');
    }
}
