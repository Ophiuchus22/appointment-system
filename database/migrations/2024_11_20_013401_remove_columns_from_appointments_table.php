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
            $table->dropColumn([
                'first_name',
                'last_name',
                'college'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('college', [
                'COLLEGE OF ARTS AND SCIENCES',
                'COLLEGE OF BUSINESS EDUCATION',
                'COLLEGE OF CRIMINAL JUSTICE',
                'COLLEGE OF ENGINEERING AND TECHNOLOGY',
                'COLLEGE OF TEACHER EDUCATION'
            ]);
        });
    }
};
