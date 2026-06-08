<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->foreignUuid('user_category_id')
                ->nullable()
                ->after('phone')
                ->constrained('user_categories')
                ->nullOnDelete();
            $table->string('organization_name')->nullable()->after('user_category_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_category_id']);
            $table->dropColumn([
                'phone',
                'user_category_id',
                'organization_name',
            ]);
        });
    }
};