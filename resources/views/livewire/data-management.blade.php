<div class="min-h-screen bg-zinc-50 p-6 transition-colors dark:bg-zinc-900">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Kelola Data</h1>
            <p class="mt-2 text-gray-600 dark:text-zinc-400">Lihat, edit, dan hapus data Project, Dokumen SAP, Material,
                dan Rincian Material</p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="mb-4 rounded-lg border border-green-400 bg-green-100 p-4 text-green-700 dark:border-green-600 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div
                class="mb-4 rounded-lg border border-red-400 bg-red-100 p-4 text-red-700 dark:border-red-600 dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tab Navigation -->
        <div class="mb-6 rounded-xl bg-white p-2 shadow-lg dark:bg-zinc-800">
            <nav class="flex flex-wrap gap-2">
                <button wire:click="$set('activeTab', 'project')"
                    class="{{ $activeTab === 'project' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-gray-600' }} flex items-center gap-2 rounded-lg px-4 py-2 font-medium transition-colors">
                    Project
                </button>
                <button wire:click="$set('activeTab', 'material_issue')"
                    class="{{ $activeTab === 'material_issue' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-gray-600' }} flex items-center gap-2 rounded-lg px-4 py-2 font-medium transition-colors">
                    Dokumen SAP
                </button>
                <button wire:click="$set('activeTab', 'material')"
                    class="{{ $activeTab === 'material' ? 'bg-purple-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-gray-600' }} flex items-center gap-2 rounded-lg px-4 py-2 font-medium transition-colors">
                    Katalog Material
                </button>
                <button wire:click="$set('activeTab', 'item')"
                    class="{{ $activeTab === 'item' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-gray-600' }} flex items-center gap-2 rounded-lg px-4 py-2 font-medium transition-colors">
                    Rincian Material
                </button>
            </nav>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-10 pr-4 shadow-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                    placeholder="Cari data...">
            </div>
        </div>

        <!-- Table Content -->
        <div class="rounded-xl bg-white shadow-lg dark:bg-zinc-800">

            {{-- ======== PROJECT TABLE ======== --}}
            @if ($activeTab === 'project')
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b border-zinc-200 bg-blue-50 text-xs uppercase text-blue-800 dark:border-zinc-700 dark:bg-blue-900/30 dark:text-blue-300">
                            <tr>
                                <th class="px-4 py-3">No SPK</th>
                                <th class="px-4 py-3">WBS</th>
                                <th class="px-4 py-3">Nama Pekerjaan</th>
                                <th class="px-4 py-3">Vendor</th>
                                <th class="px-4 py-3">Unit</th>
                                <th class="px-4 py-3">Tahun</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse ($items as $item)
                                <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $item->spk_number }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->wbs_number ?? '-' }}</td>
                                    <td class="max-w-xs truncate px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->project_name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->vendor_name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->unit_code ?? '-' }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->fiscal_year ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="editProject({{ $item->id }})"
                                                class="rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 transition-colors hover:bg-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:hover:bg-amber-900/50">
                                                Edit
                                            </button>
                                            <button
                                                wire:click="confirmDelete({{ $item->id }}, '{{ addslashes($item->spk_number) }}')"
                                                class="rounded-lg bg-red-100 px-3 py-1.5 text-xs font-medium text-red-700 transition-colors hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                        Tidak ada data project.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ======== MATERIAL ISSUE TABLE ======== --}}
            @if ($activeTab === 'material_issue')
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b border-zinc-200 bg-green-50 text-xs uppercase text-green-800 dark:border-zinc-700 dark:bg-green-900/30 dark:text-green-300">
                            <tr>
                                <th class="px-4 py-3">No. Dokumen TUG</th>
                                <th class="px-4 py-3">Project (SPK)</th>
                                <th class="px-4 py-3">Tanggal Posting</th>
                                <th class="px-4 py-3">Keterangan</th>
                                <th class="px-4 py-3 text-center">Jumlah Item</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse ($items as $item)
                                <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $item->sap_doc_no }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->project->spk_number ?? '-' }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->posting_date?->format('d/m/Y') ?? '-' }}</td>
                                    <td class="max-w-xs truncate px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->header_text ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ $item->items->count() }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="editMaterialIssue({{ $item->id }})"
                                                class="rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 transition-colors hover:bg-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:hover:bg-amber-900/50">
                                                Edit
                                            </button>
                                            <button
                                                wire:click="confirmDelete({{ $item->id }}, '{{ addslashes($item->sap_doc_no) }}')"
                                                class="rounded-lg bg-red-100 px-3 py-1.5 text-xs font-medium text-red-700 transition-colors hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                        Tidak ada data Dokumen SAP.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ======== MATERIAL TABLE ======== --}}
            @if ($activeTab === 'material')
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b border-zinc-200 bg-purple-50 text-xs uppercase text-purple-800 dark:border-zinc-700 dark:bg-purple-900/30 dark:text-purple-300">
                            <tr>
                                <th class="px-4 py-3">Kode Material</th>
                                <th class="px-4 py-3">Deskripsi</th>
                                <th class="px-4 py-3">UoM</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse ($items as $item)
                                <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $item->sap_material_code }}</td>
                                    <td class="max-w-xs truncate px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->material_description }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">{{ $item->uom ?? '-' }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">{{ $item->category ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="editMaterial({{ $item->id }})"
                                                class="rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 transition-colors hover:bg-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:hover:bg-amber-900/50">
                                                Edit
                                            </button>
                                            <button
                                                wire:click="confirmDelete({{ $item->id }}, '{{ addslashes($item->sap_material_code) }}')"
                                                class="rounded-lg bg-red-100 px-3 py-1.5 text-xs font-medium text-red-700 transition-colors hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                        Tidak ada data material.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ======== ITEM TABLE ======== --}}
            @if ($activeTab === 'item')
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead
                            class="border-b border-zinc-200 bg-orange-50 text-xs uppercase text-orange-800 dark:border-zinc-700 dark:bg-orange-900/30 dark:text-orange-300">
                            <tr>
                                <th class="px-4 py-3">Dokumen SAP</th>
                                <th class="px-4 py-3">Material</th>
                                <th class="px-4 py-3">Qty SAP</th>
                                <th class="px-4 py-3">Nilai (Rp)</th>
                                <th class="px-4 py-3">WBS Element</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse ($items as $item)
                                <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->materialIssue->sap_doc_no ?? '-' }}</td>
                                    <td
                                        class="max-w-xs truncate px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $item->material->material_description ?? '-' }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ number_format($item->quantity_sap, 2) }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->val_currency ? number_format($item->val_currency, 2) : '-' }}</td>
                                    <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                        {{ $item->wbs_element ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="editItem({{ $item->id }})"
                                                class="rounded-lg bg-amber-100 px-3 py-1.5 text-xs font-medium text-amber-700 transition-colors hover:bg-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:hover:bg-amber-900/50">
                                                Edit
                                            </button>
                                            <button
                                                wire:click="confirmDelete({{ $item->id }}, '{{ addslashes($item->material->sap_material_code ?? 'Item') }}')"
                                                class="rounded-lg bg-red-100 px-3 py-1.5 text-xs font-medium text-red-700 transition-colors hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                        Tidak ada data rincian material.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Pagination -->
            <div class="border-t border-zinc-200 px-4 py-4 dark:border-zinc-700">
                {{ $items->links() }}
            </div>
        </div>
    </div>

    {{-- ======== EDIT MODAL ======== --}}
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/50 p-4"
            wire:click.self="closeModals">
            <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl dark:bg-zinc-800">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">
                        @if ($activeTab === 'project')
                            Edit Project
                        @elseif ($activeTab === 'material_issue')
                            Edit Dokumen SAP
                        @elseif ($activeTab === 'material')
                            Edit Material
                        @else
                            Edit Rincian Material
                        @endif
                    </h3>
                    <button wire:click="closeModals"
                        class="rounded-lg p-2 text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Project Edit Form --}}
                @if ($activeTab === 'project')
                    <form wire:submit.prevent="updateProject">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nomor
                                    SPK *</label>
                                <input type="text" wire:model="edit_spk_number"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                @error('edit_spk_number')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nomor
                                    WBS</label>
                                <input type="text" wire:model="edit_wbs_number"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nama
                                    Vendor</label>
                                <input type="text" wire:model="edit_vendor_name"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Unit
                                    Code</label>
                                <input type="text" wire:model="edit_unit_code"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Tahun
                                    Fiskal</label>
                                <input type="number" wire:model="edit_fiscal_year" min="2000" max="2100"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nama
                                    Pekerjaan</label>
                                <input type="text" wire:model="edit_project_name"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeModals"
                                class="rounded-lg bg-gray-200 px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-300 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">Batal</button>
                            <button type="submit"
                                class="rounded-lg bg-blue-500 px-5 py-2.5 font-medium text-white hover:bg-blue-600">
                                <span wire:loading.remove wire:target="updateProject">Simpan</span>
                                <span wire:loading wire:target="updateProject">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                @endif

                {{-- Material Issue Edit Form --}}
                @if ($activeTab === 'material_issue')
                    <form wire:submit.prevent="updateMaterialIssue">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Project
                                    *</label>
                                <select wire:model="edit_mi_project_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                    <option value="">-- Pilih Project --</option>
                                    @foreach ($projectsList as $proj)
                                        <option value="{{ $proj->id }}">{{ $proj->spk_number }} -
                                            {{ $proj->project_name ?? 'No Name' }}</option>
                                    @endforeach
                                </select>
                                @error('edit_mi_project_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">No.
                                    Dokumen TUG *</label>
                                <input type="text" wire:model="edit_sap_doc_no"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                @error('edit_sap_doc_no')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Tanggal
                                    Posting *</label>
                                <input type="date" wire:model="edit_posting_date"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                @error('edit_posting_date')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Keterangan</label>
                                <input type="text" wire:model="edit_header_text"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeModals"
                                class="rounded-lg bg-gray-200 px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-300 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">Batal</button>
                            <button type="submit"
                                class="rounded-lg bg-green-500 px-5 py-2.5 font-medium text-white hover:bg-green-600">
                                <span wire:loading.remove wire:target="updateMaterialIssue">Simpan</span>
                                <span wire:loading wire:target="updateMaterialIssue">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                @endif

                {{-- Material Edit Form --}}
                @if ($activeTab === 'material')
                    <form wire:submit.prevent="updateMaterial">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Kode
                                    Material SAP *</label>
                                <input type="text" wire:model="edit_material_code"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                @error('edit_material_code')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Deskripsi
                                    *</label>
                                <input type="text" wire:model="edit_material_desc"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                @error('edit_material_desc')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Satuan
                                    (UoM)</label>
                                <input type="text" wire:model="edit_material_uom"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                            <div>
                                <label
                                    class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Kategori</label>
                                <input type="text" wire:model="edit_material_category"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeModals"
                                class="rounded-lg bg-gray-200 px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-300 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">Batal</button>
                            <button type="submit"
                                class="rounded-lg bg-purple-500 px-5 py-2.5 font-medium text-white hover:bg-purple-600">
                                <span wire:loading.remove wire:target="updateMaterial">Simpan</span>
                                <span wire:loading wire:target="updateMaterial">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                @endif

                {{-- Item Edit Form --}}
                @if ($activeTab === 'item')
                    <form wire:submit.prevent="updateItem">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Dokumen
                                    SAP *</label>
                                <select wire:model="edit_item_material_issue_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                    <option value="">-- Pilih Dokumen SAP --</option>
                                    @foreach ($materialIssuesList as $mi)
                                        <option value="{{ $mi->id }}">{{ $mi->sap_doc_no }} -
                                            {{ $mi->project->spk_number ?? 'No Project' }}</option>
                                    @endforeach
                                </select>
                                @error('edit_item_material_issue_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Material
                                    *</label>
                                <select wire:model="edit_item_material_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                    <option value="">-- Pilih Material --</option>
                                    @foreach ($materialsList as $mat)
                                        <option value="{{ $mat->id }}">{{ $mat->sap_material_code }} -
                                            {{ $mat->material_description }}</option>
                                    @endforeach
                                </select>
                                @error('edit_item_material_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Qty SAP
                                    *</label>
                                <input type="number" step="0.01" wire:model="edit_item_quantity_sap"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                                @error('edit_item_quantity_sap')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nilai
                                    (Rp)</label>
                                <input type="number" step="0.01" wire:model="edit_item_val_currency"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">WBS
                                    Element</label>
                                <input type="text" wire:model="edit_item_wbs_element"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" wire:click="closeModals"
                                class="rounded-lg bg-gray-200 px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-300 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">Batal</button>
                            <button type="submit"
                                class="rounded-lg bg-orange-500 px-5 py-2.5 font-medium text-white hover:bg-orange-600">
                                <span wire:loading.remove wire:target="updateItem">Simpan</span>
                                <span wire:loading wire:target="updateItem">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif

    {{-- ======== DELETE CONFIRMATION MODAL ======== --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/50 p-4"
            wire:click.self="closeModals">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-zinc-800">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Konfirmasi Hapus</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Tindakan ini tidak dapat dikembalikan.</p>
                    </div>
                </div>

                <p class="mb-6 text-zinc-700 dark:text-zinc-300">
                    Apakah Anda yakin ingin menghapus <strong
                        class="text-red-600 dark:text-red-400">{{ $deletingName }}</strong>?
                </p>

                <div class="flex justify-end gap-3">
                    <button wire:click="closeModals"
                        class="rounded-lg bg-gray-200 px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-300 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-600">
                        Batal
                    </button>
                    <button
                        wire:click="{{ $activeTab === 'project' ? 'deleteProject' : ($activeTab === 'material_issue' ? 'deleteMaterialIssue' : ($activeTab === 'material' ? 'deleteMaterial' : 'deleteItem')) }}"
                        class="rounded-lg bg-red-500 px-5 py-2.5 font-medium text-white hover:bg-red-600">
                        <span wire:loading.remove>Ya, Hapus</span>
                        <span wire:loading>Menghapus...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
