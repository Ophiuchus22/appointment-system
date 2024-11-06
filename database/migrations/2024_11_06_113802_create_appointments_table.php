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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('college', [
                'COLLEGE OF ARTS AND SCIENCES',
                'COLLEGE OF BUSINESS EDUCATION',
                'COLLEGE OF CRIMINAL JUSTICE',
                'COLLEGE OF ENGINEERING AND TECHNOLOGY',
                'COLLEGE OF TEACHER EDUCATION'
            ]);
            $table->string('email');
            $table->string('phone_number');
            $table->text('purpose');
            $table->date('date');
            $table->time('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
