<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("subject_id")->nullable();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('priority_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('group_id');
            $table->text('message');
            $table->text('attachment_url')->nullable();
            $table->text('location')->nullable();
            $table->unsignedBigInteger('assigned_to');
            $table->unsignedBigInteger('customer_id');
            $table->text('cc_recipients');
            $table->integer('is_closed')->default(0);
            $table->integer('is_readed')->default(0);
            $table->index(["is_closed"]);
            $table->dateTime('closed_time')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
