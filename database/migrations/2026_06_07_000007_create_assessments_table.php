<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('internship_application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assessor_id')->constrained('users')->cascadeOnDelete();
            $table->string('assessor_type'); // dosen, perusahaan
            $table->unsignedTinyInteger('discipline')->default(0);    // 0-100
            $table->unsignedTinyInteger('attitude')->default(0);      // 0-100
            $table->unsignedTinyInteger('skills')->default(0);        // 0-100
            $table->unsignedTinyInteger('communication')->default(0); // 0-100
            $table->unsignedTinyInteger('initiative')->default(0);    // 0-100
            $table->decimal('final_score', 5, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['internship_application_id', 'assessor_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
