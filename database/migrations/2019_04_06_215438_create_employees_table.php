<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_native')->nullable();
            $table->string('name_latin');
            $table->date('born');
            $table->char('gender', 6);
            $table->string('marital')->nullable();
            $table->string('emp_no');
            $table->string('address')->nullable();
            $table->integer('position_id')->unsigned();
            $table->enum('id_card_type', ['National ID', 'Passport', 'Driving License']);
            $table->string('id_card_no');
            $table->date('hiring_date')->nullable();
            $table->enum('hiring_status', ['Active', 'Resigned'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
