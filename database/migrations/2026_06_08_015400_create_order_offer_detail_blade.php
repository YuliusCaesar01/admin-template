<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_offer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_offer_id')->constrained('order_offers')->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->integer('qty')->default(1);
            $table->decimal('price', 15, 2)->default(0);
            $table->string('nama_mahasiswa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_offer_details');
    }
};