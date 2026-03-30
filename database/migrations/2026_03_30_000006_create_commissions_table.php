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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_discord')->nullable();
            $table->text('description');
            $table->string('character_type')->nullable(); // e.g., 'Anime', 'Realistic', 'Chibi'
            $table->integer('character_count')->default(1);
            $table->string('reference_images')->nullable(); // JSON array of paths
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('status')->default('pending'); // pending, reviewing, accepted, in_progress, completed, cancelled, rejected
            $table->date('deadline')->nullable();
            $table->text('admin_notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
