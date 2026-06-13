<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->string('faculty')->nullable()->after('phone');
            $table->string('department')->nullable()->after('faculty');
            $table->unsignedTinyInteger('semester')->nullable()->after('department');
            $table->text('address')->nullable()->after('semester');
            $table->foreignId('company_id')->nullable()->after('address')->constrained('companies')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['nim', 'phone', 'faculty', 'department', 'semester', 'address', 'company_id']);
        });
    }
};
