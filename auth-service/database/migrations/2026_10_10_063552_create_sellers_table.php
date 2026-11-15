<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->unique()->constrained();
            $table->string('store_name');
            $table->enum('seller_type', ['individual', 'business'])->default('individual');
            $table->string('store_phone')->unique()->nullable();
            $table->string('store_email')->unique()->nullable();
            $table->text('logo')->nullable();
            $table->text('banner')->nullable();
            $table->text('description')->nullable();

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('Bangladesh');

            // Verification
            $table->string('nid_number')->nullable();
            $table->string('nid_front')->nullable();
            $table->string('nid_back')->nullable();

            $table->string('trade_license_number')->nullable();
            $table->string('trade_license_document')->nullable();
            $table->text('tin_license_number')->nullable();

            $table->string('slug')
                ->unique();

            $table->tinyInteger('verification_status')
                ->default(0)
                ->comment('0: Unverified, 1: Verified, 2: Rejected');

            $table->unique(['slug', 'user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
