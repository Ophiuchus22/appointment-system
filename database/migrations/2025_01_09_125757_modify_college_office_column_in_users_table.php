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
        Schema::table('users', function (Blueprint $table) {
            // First, drop the existing ENUM column
            $table->dropColumn('college_office');
        });

        Schema::table('users', function (Blueprint $table) {
            // Then, create a new VARCHAR column
            $table->string('college_office')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('college_office');
            // If you need to revert back to ENUM, add your original ENUM definition here
        });
    }
};
