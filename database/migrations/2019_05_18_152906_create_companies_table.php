<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name_kh')->nullable();
            $table->string('company_name_en');
            $table->string('logo')->nullable();
            $table->string('type_of_business')->nullable();
            $table->string('telephone');
            $table->string('mobilephone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('street');
            $table->integer('village');
            $table->integer('commune');
            $table->integer('district');
            $table->char('province', 3);
            $table->string('postcode')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
