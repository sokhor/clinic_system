<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id');
            $table->integer('queue_no');
            $table->unsignedInteger('assigned_id')->nullable();
            $table->tinyInteger('progress')->nullable(); // 1:Nursing, 2:Doctor Visit, 3:Lab Test/Imaging, 4:Dispensery
            $table->tinyInteger('status')->default(0); // 0:Waiting, 1:In-progress, 2:Completed
            $table->boolean('ipd')->default(false);
            $table->tinyInteger('nursing')->default(false);
            $table->unsignedInteger('nursing_by_id')->nullable();
            $table->tinyInteger('nursing_status')->nullable(); // 1:In-progress, 2:Completed
            $table->boolean('doctor_visit')->default(false);
            $table->unsignedInteger('doctor_visit_by_id')->nullable();
            $table->tinyInteger('doctor_visit_status')->nullable(); // 1:In-progress, 2:Completed
            $table->boolean('imaging')->default(false);
            $table->unsignedInteger('imaging_by_id')->nullable();
            $table->tinyInteger('imaging_status')->nullable(); // 1:In-progress, 2:Completed
            $table->boolean('dispensery')->default(false);
            $table->unsignedInteger('dispensery_by_id')->nullable();
            $table->tinyInteger('dispensery_status')->nullable(); // 1:In-progress, 2:Completed
            $table->unsignedInteger('referal_id')->nullable();
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
        Schema::dropIfExists('visits');
    }
}
