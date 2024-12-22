<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First rename the column
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('college', 'college_office');
        });

        // Then modify the enum values
        DB::statement("ALTER TABLE users MODIFY college_office ENUM(
            'COLLEGE OF ARTS AND SCIENCES',
            'COLLEGE OF BUSINESS EDUCATION',
            'COLLEGE OF CRIMINAL JUSTICE',
            'COLLEGE OF ENGINEERING AND TECHNOLOGY',
            'COLLEGE OF TEACHER EDUCATION',
            'COLLEGE OF ALLIED HEALTH SCIENCES',
            'FINANCE OFFICE',
            'CASHIER\'S OFFICE',
            'REGISTRAR\'S OFFICE',
            'GUIDANCE OFFICE',
            'SSC OFFICE'
        ) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the enum values first
        DB::statement("ALTER TABLE users MODIFY college_office ENUM(
            'COLLEGE OF ARTS AND SCIENCES',
            'COLLEGE OF BUSINESS EDUCATION',
            'COLLEGE OF CRIMINAL JUSTICE',
            'COLLEGE OF ENGINEERING AND TECHNOLOGY',
            'COLLEGE OF TEACHER EDUCATION'
        ) NULL");

        // Then rename the column back
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('college_office', 'college');
        });
    }
};
