<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("ticket_id")->nullable();
            $table->unsignedBigInteger("task_subject_id")->nullable();
            $table->unsignedBigInteger('task_type_id');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('assigned_agent');
            $table->integer('is_closed')->default(0);
            $table->integer('is_readed')->default(0);
            $table->index(["is_closed"]);
            $table->dateTime('closed_time')->nullable();
            $table->text('message');
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
        Schema::dropIfExists('tasks');
    }
}
