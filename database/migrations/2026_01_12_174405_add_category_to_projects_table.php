<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Menambahkan kolom category setelah kolom project_name
            $table->string('category', 10)->nullable()->after('project_name');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('category');
        });
    }
};
