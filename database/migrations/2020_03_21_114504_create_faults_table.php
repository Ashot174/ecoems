<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faults', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->integer('fault_no');
            $table->integer('site_row');
            $table->string('fault_id');
            $table->string('hot_spot_analysis')->nullable();
            $table->integer('substation');
            $table->string('inverter');
            $table->string('string_number');
            $table->string('module');
            $table->string('table_row');
            $table->text('comments')->nullable();
            $table->string('lat');
            $table->string('long');
            $table->string('thermal_image_name');
            $table->string('digital_image_name');
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
        Schema::dropIfExists('faults');
    }
}
