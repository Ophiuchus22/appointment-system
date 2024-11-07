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
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('purpose', [
                'Academic Advising',
                'Personal Concerns',
                'Event Planning',
                'Financial Aid',
                'Graduation/Transcript Requests',
                'Other'
            ])->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('purpose');
        });
    }
};
