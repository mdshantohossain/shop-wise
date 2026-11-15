<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seller_shipping_settings', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_self_managed')->default(0);
            $table->boolean('is_free_shipping')->default(0);
            $table->decimal('inside_city_fee', 12)
                ->default(0);

            $table->decimal('outside_city_fee', 12)
                ->default(0);

            $table->string('estimated_delivery_min_days');

            $table->string('estimated_delivery_max_days');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_shipping_settings');
    }
};
