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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', ['user', 'system'])->default('user');
            $table->foreignId('actioned_by_user_id')->nullable()->constrained('users')->onDelete('cascade'); // Only used for system messages
            $table->foreignId('affects_user_id')->nullable()->constrained('users')->onDelete('set null'); // Only used for system messages
            $table->enum('action', ['added', 'removed', 'left', 'name_change', 'banner_change'])->nullable(); // Only used for system messages
            $table->text('message')->nullable();
            $table->timestamp('edited_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
