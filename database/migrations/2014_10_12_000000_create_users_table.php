<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('role', ['customer', 'supplier', 'both']);
            $table->string('phone')->nullable()->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('organization_type')->nullable();
            $table->date('incorporation_date')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('gst_phone')->nullable();
            $table->timestamp('gst_number_verified_at')->nullable();
            $table->double('sales_turnover')->nullable();
            $table->unsignedInteger('employees_count')->nullable();
            $table->string('password')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('referral_code')->nullable()->unique();
            $table->foreignIdFor(User::class, 'referrer_id')->nullable()
                ->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->boolean('customer_intro')->default(false);
            $table->boolean('supplier_intro')->default(false);
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
        Schema::dropIfExists('users');
    }
}
