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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // --- DATA DARI LOGISTIK (HEADER) ---
            $table->string('spk_number', 100)->unique(); // Unloading Point
            $table->string('wbs_number', 100)->nullable(); // WBS Element
            $table->string('project_name', 255)->nullable(); // Purchase order text
            $table->string('vendor_name', 255)->nullable(); // Document Header Text

            // [BARU] Tambahan sesuai data PDF Logistik
            $table->string('unit_code', 50)->nullable(); // BusA (Contoh: 7419)
            $table->year('fiscal_year')->nullable(); // Year (Contoh: 2025)

            // --- DATA INPUTAN KONSTRUKSI ---
            $table->string('location', 255)->nullable(); // Detail Lokasi
            $table->decimal('contract_value', 18, 2)->nullable(); // Nilai Kontrak Total
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->date('target_completion_date')->nullable();
            $table->date('bastp_date')->nullable();
            $table->date('slo_date')->nullable();
            $table->integer('progress_percent')->default(0);

            // --- DATA INPUTAN AKUNTANSI ---
            $table->string('pdp_category', 10)->nullable(); // D1.1 - D5
            $table->string('follow_up_code', 10)->nullable(); // TL-1 dst
            $table->text('constraint_note')->nullable(); // Kendala

            // --- SYSTEM ---
            $table->enum('status', ['DRAFT', 'OPEN', 'CLOSED'])->default('DRAFT');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
