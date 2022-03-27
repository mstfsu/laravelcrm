<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('color');
            $table->unsignedBigInteger("respond_within_time_value");
            $table->text("respond_within_time_type");
            $table->unsignedBigInteger("resolve_within_time_value");
            $table->text("resolve_within_time_type");
            $table->unsignedBigInteger("sms");
            $table->unsignedBigInteger("email");
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
        Schema::dropIfExists('priorities');
    }
}
