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
		Schema::table('material_issues_items', function (Blueprint $table) {
			$table->enum('approval_status', ['initial', 'process', 'pending', 'approved', 'rejected'])
				->default('initial')
				->after('asset_number_date');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('material_issues_items', function (Blueprint $table) {
			$table->dropColumn('approval_status');
		});
	}
};
