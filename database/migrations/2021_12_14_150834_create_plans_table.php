<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['STANDARD', 'PREMIUM'])->default('STANDARD');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->double('actual_amount')->nullable();
            $table->double('sale_amount')->nullable();
            $table->unsignedInteger('fresh_bids')->default(0);
            $table->unsignedInteger('additional_bids')->default(0);
            $table->unsignedInteger('validity_days')->default(0);
            $table->integer('order_pos')->default(1);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('plans');
    }
}
