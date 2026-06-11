<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_code')->unique()->nullable();
            $table->string('access_token', 6)->nullable();

            $table->enum('type', ['internal', 'external'])->default('external');

            $table->enum('status', [
                'draft',
                'submit',
                'offered',
                'rejected',
                'form_required',
                'approved',
                'processing',
                'done',
            ])->default('draft');

            $table->timestamp('sent_at')->nullable();

            // UUID Foreign Keys
            $table->foreignUuid('pic_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignUuid('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('tujuan_pengujian')->nullable();
            $table->date('waktu_diharapkan')->nullable();
            $table->text('keterangan_tambahan')->nullable();

            $table->date('waktu_pelaksanaan')->nullable();
            $table->string('lokasi_pelaksanaan')->nullable();

            $table->string('file')->nullable();
            $table->string('bukti_bayar')->nullable();

            $table->text('saran')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};