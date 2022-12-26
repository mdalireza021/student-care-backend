<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("attendance_taker_id");
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("student_class_id");
            $table->date('attendance_date');
            $table->boolean('attendance_type');
            $table->boolean('is_holiday')->default(false);
            $table->integer('day')->nullable();
            $table->integer('month')->nullable();
            $table->year('year')->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
