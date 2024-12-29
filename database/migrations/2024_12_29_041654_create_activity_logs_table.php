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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('causer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('causer_type')->nullable(); // 'admin' or 'user'
            $table->string('event'); // 'login', 'logout', 'create', 'update', 'delete', etc.
            $table->string('description');
            $table->foreignId('subject_id')->nullable(); // For appointment_id or any other related ID
            $table->string('subject_type')->nullable(); // 'appointment', 'report', etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
