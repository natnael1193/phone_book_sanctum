<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('company_name');
            $table->string('phone_number');
            $table->string('phone_number_2')->nullable();
            $table->string('email')->nullable();
            $table->longText('description');
            $table->string('fax')->nullable();
            $table->integer('count')->min(0)->nullable();
            $table->string('website')->nullable();
            $table->longText('company_logo_path')->nullable();
            $table->string('location_image_id')->nullable();
            $table->string('lang')->nullable();
            $table->longText('link_id')->nullable();
            $table->string('encoder')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
