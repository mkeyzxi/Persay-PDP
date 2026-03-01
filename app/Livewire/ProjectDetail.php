<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Projects;

class ProjectDetail extends Component
{
	public $projectId;
	public $project;
	public $materialIssues = [];
	public $summary = [];

	// Track which material issues are expanded
	public $expandedIssues = [];

	public function mount($id)
	{
		$this->projectId = $id;
		$this->loadProject();
	}

	public function loadProject()
	{
		$project = Projects::with([
			'materialIssues.items.material',
			'materialIssues.createdBy',
			'wbsLogs.setByUser',
			'documents',
			'createdBy',
		])->findOrFail($this->projectId);

		$this->project = $project;

		// Compute summary
		$saldoPdp = $project->materialIssues
			->flatMap(fn($mi) => $mi->items)
			->sum('val_currency');

		$totalQtySap = $project->materialIssues
			->flatMap(fn($mi) => $mi->items)
			->sum('quantity_sap');

		$totalQtyInstalled = $project->materialIssues
			->flatMap(fn($mi) => $mi->items)
			->sum('quantity_installed');

		$totalItems = $project->materialIssues
			->flatMap(fn($mi) => $mi->items)
			->count();

		$start = $project->contract_start_date
			? Carbon::parse($project->contract_start_date)
			: null;

		$now = Carbon::now();
		$umurHari  = $start ? $start->diffInDays($now) : 0;
		$umurBulan = $start ? $start->diffInMonths($now) : 0;

		if ($umurBulan < 3) {
			$klaster = '< 3 Bulan';
		} elseif ($umurBulan <= 6) {
			$klaster = '3 - 6 Bulan';
		} elseif ($umurBulan <= 12) {
			$klaster = '6 - 12 Bulan';
		} else {
			$klaster = '> 1 Tahun';
		}

		$this->summary = [
			'saldo_pdp' => $saldoPdp,
			'total_qty_sap' => $totalQtySap,
			'total_qty_installed' => $totalQtyInstalled,
			'total_items' => $totalItems,
			'total_material_issues' => $project->materialIssues->count(),
			'umur_hari' => $umurHari,
			'umur_bulan' => $umurBulan,
			'klaster_umur' => $klaster,
		];

		$this->materialIssues = $project->materialIssues->toArray();

		// Expand all by default
		$this->expandedIssues = $project->materialIssues->pluck('id')->toArray();
	}

	public function toggleIssue($issueId)
	{
		if (in_array($issueId, $this->expandedIssues)) {
			$this->expandedIssues = array_values(array_diff($this->expandedIssues, [$issueId]));
		} else {
			$this->expandedIssues[] = $issueId;
		}
	}

	public function expandAll()
	{
		$this->expandedIssues = collect($this->materialIssues)->pluck('id')->toArray();
	}

	public function collapseAll()
	{
		$this->expandedIssues = [];
	}

	public function render()
	{
		return view('livewire.project-detail');
	}
}
