<?php

// database/migrations/2024_01_01_000002_create_packages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->string('category_id', 100)
                ->nullable();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('base_price', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('category')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};