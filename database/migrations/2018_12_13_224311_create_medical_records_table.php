<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('visit_id');
            $table->string('marital_status')->nullable();
            $table->string('number_of_children')->nullable();
            $table->string('occupation')->nullable();
            $table->string('height')->nullable();
            $table->string('weigh')->nullable();
            $table->boolean('smoking')->nullable();
            $table->string('smoking_info')->nullable();
            $table->boolean('alcoholic')->nullable();
            $table->string('alcoholic_info')->nullable();
            $table->text('patient_complaint');
            $table->float('blood_pressure_systolic');
            $table->float('blood_pressure_diastolic');
            $table->float('pulse');
            $table->float('temperature');
            $table->float('respiratory_rate');
            $table->float('pso2');
            $table->text('anc_note')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('medical_records');
    }
}
