<?php

use App\Models\ManufacturingUnit;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(ManufacturingUnit::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('title')->nullable();
            $table->string('part_name')->nullable();
            $table->string('drawing_number')->nullable();
            $table->date('delivery_date')->nullable();
            $table->double('location_preference')->nullable();
            $table->double('raw_material_price')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('close_at')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
