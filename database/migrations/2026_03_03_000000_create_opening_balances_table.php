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
        Schema::create('opening_balances', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 18, 2)->comment('Nilai saldo awal (Rupiah)');
            $table->date('period_start')->comment('Tanggal mulai berlaku');
            $table->date('period_end')->comment('Tanggal akhir berlaku');
            $table->text('description')->nullable()->comment('Keterangan/catatan');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_balances');
    }
};
