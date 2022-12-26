<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_class_id");
            $table->unsignedBigInteger("subject_id");
            $table->unsignedBigInteger("published_by");
            $table->dateTime("published");
            $table->dateTime("completed")->nullable();
            $table->dateTime("reviewed")->nullable();
            $table->unsignedBigInteger("reviewed_by")->nullable();
            $table->boolean("done_status")->nullable(false);
            $table->float("marks")->nullable();
            $table->text("remarks")->nullable();
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
        Schema::dropIfExists('home_tasks');
    }
}
