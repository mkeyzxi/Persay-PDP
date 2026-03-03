<?php

namespace App\Livewire;

use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class DataManagement extends Component
{
	use WithPagination;

	// Active Tab
	public $activeTab = 'project';

	// Search
	public $search = '';

	// ========================================
	// EDIT STATE
	// ========================================
	public $showEditModal = false;
	public $editingId = null;

	// Project edit fields
	public $edit_spk_number;
	public $edit_wbs_number;
	public $edit_project_name;
	public $edit_vendor_name;
	public $edit_unit_code;
	public $edit_fiscal_year;
	public $edit_payment_status;

	// Material Issue edit fields
	public $edit_sap_doc_no;
	public $edit_posting_date;
	public $edit_header_text;
	public $edit_mi_project_id;

	// Material edit fields
	public $edit_material_code;
	public $edit_material_desc;
	public $edit_material_uom;
	public $edit_material_category;

	// Item edit fields
	public $edit_item_material_issue_id;
	public $edit_item_material_id;
	public $edit_item_quantity_sap;
	public $edit_item_val_currency;
	public $edit_item_wbs_element;

	// ========================================
	// DELETE STATE
	// ========================================
	public $showDeleteModal = false;
	public $deletingId = null;
	public $deletingName = '';

	// ========================================
	// DROPDOWN DATA
	// ========================================
	public $projectsList = [];
	public $materialIssuesList = [];
	public $materialsList = [];

	public function mount()
	{
		$this->loadDropdowns();
	}

	protected function loadDropdowns()
	{
		$this->projectsList = Projects::orderBy('spk_number')->get();
		$this->materialIssuesList = MaterialIssues::with('project')->orderBy('sap_doc_no')->get();
		$this->materialsList = Material::orderBy('material_description')->get();
	}

	public function updatedSearch()
	{
		$this->resetPage();
	}

	public function updatedActiveTab()
	{
		$this->resetPage();
		$this->search = '';
		$this->closeModals();
	}

	// ========================================
	// EDIT METHODS
	// ========================================

	public function editProject($id)
	{
		$project = Projects::findOrFail($id);
		$this->editingId = $id;
		$this->edit_spk_number = $project->spk_number;
		$this->edit_wbs_number = $project->wbs_number;
		$this->edit_project_name = $project->project_name;
		$this->edit_vendor_name = $project->vendor_name;
		$this->edit_unit_code = $project->unit_code;
		$this->edit_fiscal_year = $project->fiscal_year;
		$this->edit_payment_status = $project->payment_status;
		$this->showEditModal = true;
	}

	public function editMaterialIssue($id)
	{
		$mi = MaterialIssues::findOrFail($id);
		$this->editingId = $id;
		$this->edit_sap_doc_no = $mi->sap_doc_no;
		$this->edit_posting_date = $mi->posting_date?->format('Y-m-d');
		$this->edit_header_text = $mi->header_text;
		$this->edit_mi_project_id = $mi->project_id;
		$this->showEditModal = true;
	}

	public function editMaterial($id)
	{
		$material = Material::findOrFail($id);
		$this->editingId = $id;
		$this->edit_material_code = $material->sap_material_code;
		$this->edit_material_desc = $material->material_description;
		$this->edit_material_uom = $material->uom;
		$this->edit_material_category = $material->category;
		$this->showEditModal = true;
	}

	public function editItem($id)
	{
		$item = MaterialIssuesItems::findOrFail($id);
		$this->editingId = $id;
		$this->edit_item_material_issue_id = $item->material_issue_id;
		$this->edit_item_material_id = $item->material_id;
		$this->edit_item_quantity_sap = $item->quantity_sap;
		$this->edit_item_val_currency = $item->val_currency;
		$this->edit_item_wbs_element = $item->wbs_element;
		$this->loadDropdowns();
		$this->showEditModal = true;
	}

	// ========================================
	// UPDATE METHODS
	// ========================================

	public function updateProject()
	{
		$this->validate([
			'edit_spk_number'   => 'required|string|max:100',
			'edit_wbs_number'   => 'nullable|string|max:100',
			'edit_project_name' => 'nullable|string|max:255',
			'edit_vendor_name'  => 'nullable|string|max:255',
			'edit_unit_code'    => 'nullable|string|max:50',
			'edit_fiscal_year'    => 'nullable|integer|min:2000|max:2100',
			'edit_payment_status' => 'nullable|in:unpaid,in_progress,paid',
		]);

		try {
			$project = Projects::findOrFail($this->editingId);
			$project->update([
				'spk_number'   => $this->edit_spk_number,
				'wbs_number'   => $this->edit_wbs_number,
				'project_name' => $this->edit_project_name,
				'vendor_name'  => $this->edit_vendor_name,
				'unit_code'    => $this->edit_unit_code,
				'fiscal_year'      => $this->edit_fiscal_year,
				'payment_status'   => $this->edit_payment_status,
			]);
			$this->closeModals();
			session()->flash('success', 'Project berhasil diupdate!');
		} catch (\Exception $e) {
			session()->flash('error', 'Gagal mengupdate: ' . $e->getMessage());
		}
	}

	public function updateMaterialIssue()
	{
		$this->validate([
			'edit_sap_doc_no'    => 'required|string|max:100',
			'edit_posting_date'  => 'required|date',
			'edit_header_text'   => 'nullable|string|max:500',
			'edit_mi_project_id' => 'required|exists:projects,id',
		]);

		try {
			$mi = MaterialIssues::findOrFail($this->editingId);
			$mi->update([
				'sap_doc_no'   => $this->edit_sap_doc_no,
				'posting_date' => $this->edit_posting_date,
				'header_text'  => $this->edit_header_text,
				'project_id'   => $this->edit_mi_project_id,
			]);
			$this->closeModals();
			session()->flash('success', 'Dokumen SAP berhasil diupdate!');
		} catch (\Exception $e) {
			session()->flash('error', 'Gagal mengupdate: ' . $e->getMessage());
		}
	}

	public function updateMaterial()
	{
		$this->validate([
			'edit_material_code'     => 'required|string|max:100',
			'edit_material_desc'     => 'required|string|max:255',
			'edit_material_uom'      => 'nullable|string|max:20',
			'edit_material_category' => 'nullable|string|max:100',
		]);

		try {
			$material = Material::findOrFail($this->editingId);
			$material->update([
				'sap_material_code'    => $this->edit_material_code,
				'material_description' => $this->edit_material_desc,
				'uom'                  => $this->edit_material_uom,
				'category'             => $this->edit_material_category,
			]);
			$this->closeModals();
			session()->flash('success', 'Material berhasil diupdate!');
		} catch (\Exception $e) {
			session()->flash('error', 'Gagal mengupdate: ' . $e->getMessage());
		}
	}

	public function updateItem()
	{
		$this->validate([
			'edit_item_material_issue_id' => 'required|exists:material_issues,id',
			'edit_item_material_id'       => 'required|exists:materials,id',
			'edit_item_quantity_sap'      => 'required|numeric|min:0',
			'edit_item_val_currency'      => 'nullable|numeric|min:0',
			'edit_item_wbs_element'       => 'nullable|string|max:100',
		]);

		try {
			$item = MaterialIssuesItems::findOrFail($this->editingId);
			$item->update([
				'material_issue_id' => $this->edit_item_material_issue_id,
				'material_id'       => $this->edit_item_material_id,
				'quantity_sap'      => $this->edit_item_quantity_sap,
				'val_currency'      => $this->edit_item_val_currency,
				'wbs_element'       => $this->edit_item_wbs_element,
			]);
			$this->closeModals();
			session()->flash('success', 'Item berhasil diupdate!');
		} catch (\Exception $e) {
			session()->flash('error', 'Gagal mengupdate: ' . $e->getMessage());
		}
	}

	// ========================================
	// DELETE METHODS
	// ========================================

	public function confirmDelete($id, $name = '')
	{
		$this->deletingId = $id;
		$this->deletingName = $name;
		$this->showDeleteModal = true;
	}

	public function deleteProject()
	{
		try {
			$project = Projects::findOrFail($this->deletingId);

			// Check if project has material issues
			if ($project->materialIssues()->count() > 0) {
				session()->flash('error', 'Tidak bisa menghapus project yang masih memiliki Dokumen SAP. Hapus Dokumen SAP terlebih dahulu.');
				$this->closeModals();
				return;
			}

			$project->delete();
			$this->closeModals();
			session()->flash('success', 'Project berhasil dihapus!');
		} catch (\Exception $e) {
			session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
		}
	}

	public function deleteMaterialIssue()
	{
		try {
			$mi = MaterialIssues::findOrFail($this->deletingId);

			// Delete related items first
			$mi->items()->delete();
			$mi->delete();
			$this->closeModals();
			session()->flash('success', 'Dokumen SAP dan item terkait berhasil dihapus!');
		} catch (\Exception $e) {
			session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
		}
	}

	public function deleteMaterial()
	{
		try {
			$material = Material::findOrFail($this->deletingId);

			// Check if material is used in items
			if ($material->issueItems()->count() > 0) {
				session()->flash('error', 'Tidak bisa menghapus material yang masih digunakan di Rincian Material. Hapus rincian terlebih dahulu.');
				$this->closeModals();
				return;
			}

			$material->delete();
			$this->closeModals();
			session()->flash('success', 'Material berhasil dihapus!');
		} catch (\Exception $e) {
			session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
		}
	}

	public function deleteItem()
	{
		try {
			$item = MaterialIssuesItems::findOrFail($this->deletingId);
			$item->delete();
			$this->closeModals();
			session()->flash('success', 'Item berhasil dihapus!');
		} catch (\Exception $e) {
			session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
		}
	}

	// ========================================
	// HELPERS
	// ========================================

	public function closeModals()
	{
		$this->showEditModal = false;
		$this->showDeleteModal = false;
		$this->editingId = null;
		$this->deletingId = null;
		$this->deletingName = '';
		$this->resetValidation();
	}

	public function render()
	{
		$data = [];

		switch ($this->activeTab) {
			case 'project':
				$data['items'] = Projects::when($this->search, function ($q) {
					$q->where('spk_number', 'like', '%' . $this->search . '%')
						->orWhere('project_name', 'like', '%' . $this->search . '%')
						->orWhere('vendor_name', 'like', '%' . $this->search . '%')
						->orWhere('wbs_number', 'like', '%' . $this->search . '%');
				})->orderBy('created_at', 'desc')->paginate(15);
				break;

			case 'material_issue':
				$data['items'] = MaterialIssues::with('project')
					->when($this->search, function ($q) {
						$q->where('sap_doc_no', 'like', '%' . $this->search . '%')
							->orWhere('header_text', 'like', '%' . $this->search . '%')
							->orWhereHas('project', function ($q2) {
								$q2->where('spk_number', 'like', '%' . $this->search . '%');
							});
					})->orderBy('created_at', 'desc')->paginate(15);
				break;

			case 'material':
				$data['items'] = Material::when($this->search, function ($q) {
					$q->where('sap_material_code', 'like', '%' . $this->search . '%')
						->orWhere('material_description', 'like', '%' . $this->search . '%')
						->orWhere('category', 'like', '%' . $this->search . '%');
				})->orderBy('material_description')->paginate(15);
				break;

			case 'item':
				$data['items'] = MaterialIssuesItems::with(['materialIssue.project', 'material'])
					->when($this->search, function ($q) {
						$q->where('wbs_element', 'like', '%' . $this->search . '%')
							->orWhereHas('material', function ($q2) {
								$q2->where('material_description', 'like', '%' . $this->search . '%')
									->orWhere('sap_material_code', 'like', '%' . $this->search . '%');
							})
							->orWhereHas('materialIssue', function ($q2) {
								$q2->where('sap_doc_no', 'like', '%' . $this->search . '%');
							});
					})->orderBy('created_at', 'desc')->paginate(15);
				break;
		}

		$data['projectsList'] = $this->projectsList;
		$data['materialIssuesList'] = $this->materialIssuesList;
		$data['materialsList'] = $this->materialsList;

		return view('livewire.data-management', $data);
	}
}
