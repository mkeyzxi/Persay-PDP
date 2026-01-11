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
        Schema::create('project_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->enum('document_type', ['BASTP', 'KALKIR', 'TUG9', 'TUG10', 'LAINNYA']);
            $table->string('file_path');
            $table->string('original_filename');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('uploaded_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_documents');
    }
};
