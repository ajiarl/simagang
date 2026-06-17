<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->string('verification_token')->nullable()->unique()->after('status');
        });

        // Generate tokens for existing completed applications
        $completedApps = \DB::table('internship_applications')->where('status', 'completed')->get();
        foreach ($completedApps as $app) {
            \DB::table('internship_applications')
                ->where('id', $app->id)
                ->update(['verification_token' => (string) \Illuminate\Support\Str::uuid()]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn('verification_token');
        });
    }
};
