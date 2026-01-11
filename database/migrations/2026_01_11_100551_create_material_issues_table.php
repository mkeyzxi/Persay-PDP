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
        Schema::create('material_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('sap_doc_no', 100);
            $table->date('posting_date')->nullable();
            $table->string('header_text', 255)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_issues');
    }
};
