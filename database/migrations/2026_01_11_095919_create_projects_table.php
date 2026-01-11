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
            $table->string('spk_number', 100)->unique();
            $table->string('wbs_number', 100)->nullable();
            $table->string('project_name', 255)->nullable();
            $table->string('vendor_name', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->decimal('contract_value', 18, 2)->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->date('bastp_date')->nullable();
            $table->date('slo_date')->nullable();
            $table->integer('progress_percent')->default(0);
            $table->string('pdp_category', 10)->nullable();
            $table->string('follow_up_code', 10)->nullable();
            $table->text('constraint_note')->nullable();
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
