<?php

use App\Models\Package;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignIdFor(Project::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Package::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('bids');
            $table->unsignedDouble('base_amount')->default(0);
            $table->unsignedDouble('gst_amount')->default(0);
            $table->unsignedDouble('final_amount')->default(0);
            $table->string('mode');
            $table->timestamp('paid_at')->nullable();
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
        Schema::dropIfExists('project_transactions');
    }
}
