<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentMapInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_map_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agent_id')->unsigned();
            $table->string('coordinates');
            $table->string('speed');
            $table->string('accuracy');
            $table->string('altitude');
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
        Schema::dropIfExists('agent_map_infos');
    }
}
