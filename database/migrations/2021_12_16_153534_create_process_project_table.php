<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_project', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Process::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(\App\Models\Project::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('process_project');
    }
}
