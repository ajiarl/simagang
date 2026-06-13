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
        Schema::table('internship_periods', function (Blueprint $table) {
            $table->date('registration_start')->after('name')->nullable();
            $table->date('registration_end')->after('registration_start')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_periods', function (Blueprint $table) {
            $table->dropColumn(['registration_start', 'registration_end']);
        });
    }
};
