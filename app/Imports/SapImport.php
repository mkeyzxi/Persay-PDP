<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SapImport implements OnEachRow, WithHeadingRow
{
	public function onRow(Row $row)
	{
		$data = $row->toArray();

		// Skip empty rows
		if (empty($data['unloading_point']) || empty($data['material'])) {
			return;
		}

		DB::transaction(function () use ($data) {

			/**
			 * 1️⃣ PROJECT (MASTER)
			 * Disatukan berdasarkan Unloading Point (SPK)
			 */
			$project = Projects::firstOrCreate(
				[
					'spk_number' => $data['unloading_point'],
				],
				[
					'wbs_number'   => $data['wbs_element'] ?? null,
					'project_name' => $data['purchase_order_text'] ?? null,
					'vendor_name'  => $data['name'] ?? null,
					'unit_code'    => $data['busa'] ?? null,
					'fiscal_year'  => $this->extractYear($data['doc_date'] ?? null),
					'status'       => 'DRAFT',
					'created_by'   => Auth::id(),
				]
			);

			/**
			 * 2️⃣ MATERIAL (MASTER)
			 * Unik per SAP Material Code
			 */
			$material = Material::firstOrCreate(
				['sap_material_code' => $data['material']],
				[
					'material_description' => $data['material_description'] ?? 'Unknown',
					'uom'      => $data['posted_unit_of_meas'] ?? 'EA',
					'category' => 'NON-MDU', // Default category
				]
			);

			/**
			 * 3️⃣ MATERIAL ISSUE (HEADER SAP)
			 * Unik per RefDocNo (Nomor dokumen referensi)
			 */
			$issue = MaterialIssues::firstOrCreate(
				[
					'sap_doc_no' => $data['refdocno'] ?? $data['material'] . '-' . time(),
				],
				[
					'project_id'   => $project->id,
					'posting_date' => $this->parseDate($data['postg_date'] ?? null),
					'header_text'  => $data['document_header_text'] ?? null,
					'created_by'   => Auth::id(),
				]
			);

			/**
			 * 4️⃣ MATERIAL ISSUE ITEM (DETAIL)
			 * Selalu create (1 SAP bisa banyak item)
			 */
			MaterialIssuesItems::create([
				'material_issue_id' => $issue->id,
				'material_id'       => $material->id,
				'quantity_sap'      => $this->parseNumber($data['quantity'] ?? 0),
				'val_currency'      => $this->parseNumber($data['valcoarea_crcy'] ?? $data['val_coarea_crcy'] ?? 0),
				'wbs_element'       => $data['wbs_element'] ?? null,
			]);
		});
	}

	/**
	 * Parse date from various formats
	 */
	private function parseDate($value)
	{
		if (empty($value)) {
			return null;
		}

		// If it's already a date object or timestamp
		if ($value instanceof \DateTime) {
			return $value->format('Y-m-d');
		}

		// If it's a numeric Excel date
		if (is_numeric($value)) {
			return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
		}

		// Try to parse string date
		try {
			return date('Y-m-d', strtotime($value));
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * Extract year from date
	 */
	private function extractYear($value)
	{
		if (empty($value)) {
			return date('Y');
		}

		if (is_numeric($value) && $value > 1900 && $value < 2100) {
			return (int) $value;
		}

		$date = $this->parseDate($value);
		return $date ? (int) date('Y', strtotime($date)) : date('Y');
	}

	/**
	 * Parse number from string (handle comma as decimal separator)
	 */
	private function parseNumber($value)
	{
		if (empty($value)) {
			return 0;
		}

		if (is_numeric($value)) {
			return (float) $value;
		}

		// Remove thousand separators and convert comma to dot
		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);

		return (float) $value;
	}
}
