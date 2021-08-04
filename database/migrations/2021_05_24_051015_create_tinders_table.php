<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tinders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->unsignedBigInteger('tender_sub_category_id');
            $table->string('price');
            $table->string('bond');
            $table->string('type');
            $table->string('opening_date');
            $table->string('closing_date');
            $table->string('closing_time');
            $table->string('location');
            $table->string('reference');
            $table->string('reference_date');
            $table->string('company_id');
            $table->string('image')->nullable();
            $table->string('title');
            $table->string('description');
            $table->string('title_am');
            $table->string('description_am');
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
        Schema::dropIfExists('tinders');
    }
}