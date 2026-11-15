<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserSession;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_session_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserSession::class)->constrained()->cascadeOnDelete();
            $table->char('token_hash', 64)->unique();
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamp('revoked_at')->nullable();

            $table->foreignId('replaced_by_id')
                ->nullable()
                ->constrained('user_session_tokens')
                ->nullOnDelete();

            $table->timestamps();

            $table->index([
                'user_session_id',
                'expires_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_session_tokens');
    }
};
