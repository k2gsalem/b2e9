<?php

use App\Models\ManufacturingUnit;
use App\Models\Project;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(Subscription::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignIdFor(ManufacturingUnit::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->double('amount');
            $table->boolean('valid')->default(false)->index();
            $table->unsignedInteger('edit_count')->default(0);
            $table->json('edit_history')->default('[]');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'user_id', 'manufacturing_unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
