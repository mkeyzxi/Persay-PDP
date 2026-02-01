<div class="min-h-screen bg-zinc-50 p-6 transition-colors dark:bg-zinc-900">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Manual Input</h1>
            <p class="mt-2 text-gray-600 dark:text-zinc-400">Input data Project, Material Issue, Material, dan Item
                secara manual</p>
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
                    class="{{ $activeTab === 'project' ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-gray-600' }} flex items-center gap-2 rounded-lg px-4 py-2 font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Project
                </button>
                <button wire:click="$set('activeTab', 'material_issue')"
                    class="{{ $activeTab === 'material_issue' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-gray-600' }} flex items-center gap-2 rounded-lg px-4 py-2 font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Material Issue
                </button>
                <button wire:click="$set('activeTab', 'material')"
                    class="{{ $activeTab === 'material' ? 'bg-purple-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-gray-600' }} flex items-center gap-2 rounded-lg px-4 py-2 font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Material
                </button>
                <button wire:click="$set('activeTab', 'item')"
                    class="{{ $activeTab === 'item' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-300 dark:hover:bg-gray-600' }} flex items-center gap-2 rounded-lg px-4 py-2 font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Item
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">

            {{-- ========================================
                PROJECT TAB
            ======================================== --}}
            @if ($activeTab === 'project')
                <div>
                    <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold text-zinc-800 dark:text-zinc-100">
                        <span class="bg-primary-500 rounded-lg p-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </span>
                        Tambah Project Baru
                    </h2>

                    <form wire:submit.prevent="saveProject">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <!-- SPK Number -->
                            <div
                                class="border-primary-500 bg-primary-50 dark:bg-primary-900/20 rounded-lg border-2 p-3">
                                <label
                                    class="text-primary-800 dark:text-primary-300 mb-1 block text-sm font-medium">Nomor
                                    SPK *</label>
                                <input type="text" wire:model="spk_number"
                                    class="border-primary-300 dark:border-primary-600 focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border bg-white px-4 py-2 focus:ring-2 dark:bg-zinc-700 dark:text-white"
                                    placeholder="SPK-2026-001">
                                @error('spk_number')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- WBS Number -->
                            <div class="rounded-lg border-2 border-gray-300 bg-zinc-50 p-3 dark:bg-zinc-700/30">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nomor
                                    WBS</label>
                                <input type="text" wire:model="wbs_number"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-gray-500 focus:ring-2 focus:ring-gray-500 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                    placeholder="WBS.001.002">
                            </div>

                            <!-- Vendor Name -->
                            <div class="rounded-lg border-2 border-gray-300 bg-zinc-50 p-3 dark:bg-zinc-700/30">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nama
                                    Vendor</label>
                                <input type="text" wire:model="vendor_name"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-gray-500 focus:ring-2 focus:ring-gray-500 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                    placeholder="PT. Kontraktor ABC">
                            </div>

                            <!-- Unit Code -->
                            <div class="rounded-lg border-2 border-gray-300 bg-zinc-50 p-3 dark:bg-zinc-700/30">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Unit
                                    Code</label>
                                <input type="text" wire:model="unit_code"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-gray-500 focus:ring-2 focus:ring-gray-500 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                    placeholder="5100">
                            </div>

                            <!-- Fiscal Year -->
                            <div class="rounded-lg border-2 border-gray-300 bg-zinc-50 p-3 dark:bg-zinc-700/30">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Tahun
                                    Fiskal</label>
                                <input type="number" wire:model="fiscal_year"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-gray-500 focus:ring-2 focus:ring-gray-500 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                    placeholder="2026" min="2000" max="2100">
                            </div>

                            <!-- Project Name -->
                            <div
                                class="rounded-lg border-2 border-gray-300 bg-zinc-50 p-3 md:col-span-2 lg:col-span-3 dark:bg-zinc-700/30">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nama
                                    Pekerjaan</label>
                                <input type="text" wire:model="project_name"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-gray-500 focus:ring-2 focus:ring-gray-500 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                    placeholder="Pembangunan Gardu">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="bg-primary-500 hover:bg-primary-600 focus:ring-primary-500 rounded-lg px-6 py-3 font-semibold text-white shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">
                                <span wire:loading.remove wire:target="saveProject">Simpan Project</span>
                                <span wire:loading wire:target="saveProject">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- ========================================
                MATERIAL ISSUE TAB
            ======================================== --}}
            @if ($activeTab === 'material_issue')
                <div>
                    <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold text-zinc-800 dark:text-zinc-100">
                        <span class="rounded-lg bg-green-500 p-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        Tambah Material Issue
                    </h2>

                    <form wire:submit.prevent="saveMaterialIssue">
                        <!-- Project Mode Selection -->
                        <div class="mb-6 rounded-lg border-2 border-green-400 bg-green-50 p-4 dark:bg-green-900/20">
                            <label class="mb-3 block text-sm font-medium text-green-800 dark:text-green-300">Ke Project
                                Mana?</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" wire:model.live="mi_project_mode" value="existing"
                                        class="text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700 dark:text-zinc-300">Project yang
                                        Sudah Ada</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" wire:model.live="mi_project_mode" value="new_project"
                                        class="text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700 dark:text-zinc-300">Buat Project
                                        Baru</span>
                                </label>
                            </div>
                        </div>

                        <!-- Existing Project Selection -->
                        @if ($mi_project_mode === 'existing')
                            <div class="mb-6">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Pilih
                                    Project *</label>
                                <select wire:model.live="mi_selected_project_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                                    <option value="">-- Pilih Project --</option>
                                    @foreach ($projects as $proj)
                                        <option value="{{ $proj->id }}">{{ $proj->spk_number }} -
                                            {{ $proj->project_name ?? 'No Name' }}</option>
                                    @endforeach
                                </select>
                                @error('mi_selected_project_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <!-- New Project Form -->
                            <div class="mb-6 rounded-lg border-2 border-blue-300 bg-blue-50 p-4 dark:bg-blue-900/20">
                                <h4 class="mb-3 font-medium text-blue-800 dark:text-blue-300">Data Project Baru</h4>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nomor
                                            SPK *</label>
                                        <input type="text" wire:model="mi_spk_number"
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                            placeholder="SPK-2026-001">
                                        @error('mi_spk_number')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">WBS
                                            Number</label>
                                        <input type="text" wire:model="mi_wbs_number"
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                            placeholder="WBS.001">
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nama
                                            Pekerjaan</label>
                                        <input type="text" wire:model="mi_project_name"
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                            placeholder="Pembangunan Gardu">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Material Issue Fields -->
                        <div class="mb-6">
                            <h4 class="mb-3 font-medium text-zinc-800 dark:text-zinc-100">Data Material Issue</h4>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                <div class="rounded-lg border-2 border-green-400 bg-green-50 p-3 dark:bg-green-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">No.
                                        Dokumen TUG *</label>
                                    <input type="text" wire:model="sap_doc_no"
                                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 dark:border-green-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="4900012345">
                                    @error('sap_doc_no')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="rounded-lg border-2 border-green-400 bg-green-50 p-3 dark:bg-green-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Tanggal
                                        Posting *</label>
                                    <input type="date" wire:model="posting_date"
                                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 dark:border-green-600 dark:bg-zinc-700 dark:text-white">
                                    @error('posting_date')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div
                                    class="rounded-lg border-2 border-green-400 bg-green-50 p-3 md:col-span-2 lg:col-span-1 dark:bg-green-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Keterangan</label>
                                    <input type="text" wire:model="header_text"
                                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 dark:border-green-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="Keterangan header">
                                </div>
                            </div>
                        </div>

                        <!-- Include Items Toggle -->
                        <div class="mb-6 rounded-lg border-2 border-orange-400 bg-orange-50 p-4 dark:bg-orange-900/20">
                            <label class="flex cursor-pointer items-center gap-3">
                                <input type="checkbox" wire:model.live="mi_include_items"
                                    class="h-5 w-5 rounded border-orange-300 text-orange-600 focus:ring-orange-500">
                                <span class="font-medium text-orange-800 dark:text-orange-300">Sekalian Tambahkan Item
                                    Material</span>
                            </label>
                        </div>

                        <!-- Item Form (if included) -->
                        @if ($mi_include_items)
                            <div
                                class="mb-6 rounded-lg border-2 border-orange-400 bg-orange-50 p-4 dark:bg-orange-900/20">
                                <h4 class="mb-4 font-medium text-orange-800 dark:text-orange-300">Data Item</h4>

                                <!-- Material Mode -->
                                <div class="mb-4 flex flex-wrap gap-4">
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" wire:model.live="mi_item_mode"
                                            value="existing_material" class="text-orange-600 focus:ring-orange-500">
                                        <span class="text-sm text-gray-700 dark:text-zinc-300">Pilih Material yang
                                            Ada</span>
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" wire:model.live="mi_item_mode" value="new_material"
                                            class="text-orange-600 focus:ring-orange-500">
                                        <span class="text-sm text-gray-700 dark:text-zinc-300">Buat Material
                                            Baru</span>
                                    </label>
                                </div>

                                @if ($mi_item_mode === 'existing_material')
                                    <div class="mb-4">
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Pilih
                                            Material *</label>
                                        <select wire:model="mi_material_id"
                                            class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white">
                                            <option value="">-- Pilih Material --</option>
                                            @foreach ($materials as $mat)
                                                <option value="{{ $mat->id }}">{{ $mat->sap_material_code }} -
                                                    {{ $mat->material_description }}</option>
                                            @endforeach
                                        </select>
                                        @error('mi_material_id')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @else
                                    <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Kode
                                                Material *</label>
                                            <input type="text" wire:model="mi_new_material_code"
                                                class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                                placeholder="MAT-001">
                                            @error('mi_new_material_code')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Deskripsi
                                                *</label>
                                            <input type="text" wire:model="mi_new_material_desc"
                                                class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                                placeholder="Kabel XLPE 20kV">
                                            @error('mi_new_material_desc')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Satuan</label>
                                            <input type="text" wire:model="mi_new_material_uom"
                                                class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                                placeholder="METER">
                                        </div>
                                        <div>
                                            <label
                                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Kategori</label>
                                            <input type="text" wire:model="mi_new_material_category"
                                                class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                                placeholder="MDU/NON-MDU/JASA">
                                        </div>
                                    </div>
                                @endif

                                <!-- Item Details -->
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Qty
                                            *</label>
                                        <input type="number" wire:model="mi_quantity_sap" step="0.01"
                                            class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                            placeholder="100">
                                        @error('mi_quantity_sap')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nilai
                                            (Rp)</label>
                                        <input type="number" wire:model="mi_val_currency" step="0.01"
                                            class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                            placeholder="5000000">
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">WBS
                                            Item</label>
                                        <input type="text" wire:model="mi_item_wbs_element"
                                            class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                            placeholder="WBS.001.002.003">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-end">
                            <button type="submit"
                                class="rounded-lg bg-green-500 px-6 py-3 font-semibold text-white shadow-lg transition-colors hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <span wire:loading.remove wire:target="saveMaterialIssue">
                                    {{ $mi_include_items ? 'Simpan Material Issue + Item' : 'Simpan Material Issue' }}
                                </span>
                                <span wire:loading wire:target="saveMaterialIssue">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- ========================================
                MATERIAL TAB
            ======================================== --}}
            @if ($activeTab === 'material')
                <div>
                    <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold text-zinc-800 dark:text-zinc-100">
                        <span class="rounded-lg bg-purple-500 p-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </span>
                        Kelola Material
                    </h2>

                    <!-- Material Mode Selection -->
                    <div class="mb-6 rounded-lg border-2 border-purple-400 bg-purple-50 p-4 dark:bg-purple-900/20">
                        <label class="mb-3 block text-sm font-medium text-purple-800 dark:text-purple-300">Apa yang
                            ingin dilakukan?</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" wire:model.live="material_mode" value="new"
                                    class="text-purple-600 focus:ring-purple-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-zinc-300">Tambah Material
                                    Baru</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" wire:model.live="material_mode" value="edit"
                                    class="text-purple-600 focus:ring-purple-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-zinc-300">Edit Material yang
                                    Ada</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" wire:model.live="material_mode" value="add_to_mi"
                                    class="text-purple-600 focus:ring-purple-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-zinc-300">Tambah Material ke
                                    MI</span>
                            </label>
                        </div>
                    </div>

                    <form wire:submit.prevent="saveMaterial">
                        @if ($material_mode === 'edit' || $material_mode === 'add_to_mi')
                            <div class="mb-4">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Pilih
                                    Material *</label>
                                <select wire:model.live="selected_material_id" wire:change="loadMaterialForEdit"
                                    class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white">
                                    <option value="">-- Pilih Material --</option>
                                    @foreach ($materials as $mat)
                                        <option value="{{ $mat->id }}">{{ $mat->sap_material_code }} -
                                            {{ $mat->material_description }}</option>
                                    @endforeach
                                </select>
                                @error('selected_material_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        @if ($material_mode === 'new' || $material_mode === 'edit')
                            <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div
                                    class="rounded-lg border-2 border-purple-400 bg-purple-50 p-3 dark:bg-purple-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-purple-800 dark:text-purple-300">Kode
                                        Material SAP *</label>
                                    <input type="text" wire:model="material_code"
                                        class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="MAT-001">
                                    @error('material_code')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div
                                    class="rounded-lg border-2 border-purple-400 bg-purple-50 p-3 dark:bg-purple-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-purple-800 dark:text-purple-300">Deskripsi
                                        *</label>
                                    <input type="text" wire:model="material_desc"
                                        class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="Kabel XLPE 20kV">
                                    @error('material_desc')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="rounded-lg border-2 border-gray-300 bg-zinc-50 p-3 dark:bg-zinc-700/30">
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Satuan
                                        (UoM)</label>
                                    <input type="text" wire:model="material_uom"
                                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                        placeholder="METER">
                                </div>
                                <div class="rounded-lg border-2 border-gray-300 bg-zinc-50 p-3 dark:bg-zinc-700/30">
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Kategori</label>
                                    <input type="text" wire:model="material_category"
                                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                        placeholder="MDU/NON-MDU/JASA">
                                </div>
                            </div>
                        @endif

                        @if ($material_mode === 'add_to_mi')
                            <div class="mb-6">
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-zinc-300">Pilih
                                    Material Issue *</label>
                                <select wire:model="mat_selected_mi_id"
                                    class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white">
                                    <option value="">-- Pilih Material Issue --</option>
                                    @foreach ($materialIssues as $mi)
                                        <option value="{{ $mi->id }}">{{ $mi->sap_doc_no }} -
                                            {{ $mi->project->spk_number ?? 'No Project' }}</option>
                                    @endforeach
                                </select>
                                @error('mat_selected_mi_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div
                                    class="rounded-lg border-2 border-orange-400 bg-orange-50 p-3 dark:bg-orange-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">Qty
                                        *</label>
                                    <input type="number" wire:model="mat_quantity_sap" step="0.01"
                                        class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="100">
                                    @error('mat_quantity_sap')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div
                                    class="rounded-lg border-2 border-orange-400 bg-orange-50 p-3 dark:bg-orange-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">Nilai
                                        (Rp)</label>
                                    <input type="number" wire:model="mat_val_currency" step="0.01"
                                        class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="5000000">
                                </div>
                                <div
                                    class="rounded-lg border-2 border-orange-400 bg-orange-50 p-3 dark:bg-orange-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">WBS
                                        Element</label>
                                    <input type="text" wire:model="mat_wbs_element"
                                        class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="WBS.001.002.003">
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-end">
                            <button type="submit"
                                class="rounded-lg bg-purple-500 px-6 py-3 font-semibold text-white shadow-lg transition-colors hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                <span wire:loading.remove wire:target="saveMaterial">
                                    @if ($material_mode === 'new')
                                        Tambah Material
                                    @elseif ($material_mode === 'edit')
                                        Update Material
                                    @else
                                        Tambah ke Material Issue
                                    @endif
                                </span>
                                <span wire:loading wire:target="saveMaterial">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- ========================================
                ITEM TAB
            ======================================== --}}
            @if ($activeTab === 'item')
                <div>
                    <h2 class="mb-4 flex items-center gap-2 text-xl font-semibold text-zinc-800 dark:text-zinc-100">
                        <span class="rounded-lg bg-orange-500 p-2 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:hidden" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </span>
                        Tambah Item
                    </h2>

                    <!-- MI Mode Selection -->
                    <div class="mb-6 rounded-lg border-2 border-orange-400 bg-orange-50 p-4 dark:bg-orange-900/20">
                        <label class="mb-3 block text-sm font-medium text-orange-800 dark:text-orange-300">Ke Material
                            Issue Mana?</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" wire:model.live="item_mi_mode" value="existing_mi"
                                    class="text-orange-600 focus:ring-orange-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-zinc-300">Material Issue yang
                                    Sudah Ada</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="radio" wire:model.live="item_mi_mode" value="new_mi"
                                    class="text-orange-600 focus:ring-orange-500">
                                <span class="text-sm font-medium text-gray-700 dark:text-zinc-300">Buat Material Issue
                                    Baru</span>
                            </label>
                        </div>
                    </div>

                    <form wire:submit.prevent="saveItem">
                        @if ($item_mi_mode === 'existing_mi')
                            <div class="mb-6">
                                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Pilih
                                    Material Issue *</label>
                                <select wire:model="item_selected_mi_id"
                                    class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white">
                                    <option value="">-- Pilih Material Issue --</option>
                                    @foreach ($materialIssues as $mi)
                                        <option value="{{ $mi->id }}">{{ $mi->sap_doc_no }} -
                                            {{ $mi->project->spk_number ?? 'No Project' }}
                                            ({{ $mi->posting_date }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('item_selected_mi_id')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <!-- New MI Form -->
                            <div
                                class="mb-6 rounded-lg border-2 border-green-400 bg-green-50 p-4 dark:bg-green-900/20">
                                <h4 class="mb-3 font-medium text-green-800 dark:text-green-300">Data Material Issue
                                    Baru</h4>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Pilih
                                            Project *</label>
                                        <select wire:model.live="item_selected_project_id"
                                            class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 dark:border-green-600 dark:bg-zinc-700 dark:text-white">
                                            <option value="">-- Pilih Project --</option>
                                            @foreach ($projects as $proj)
                                                <option value="{{ $proj->id }}">{{ $proj->spk_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('item_selected_project_id')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">No.
                                            Dokumen TUG *</label>
                                        <input type="text" wire:model="item_sap_doc_no"
                                            class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 dark:border-green-600 dark:bg-zinc-700 dark:text-white"
                                            placeholder="4900012345">
                                        @error('item_sap_doc_no')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Tanggal
                                            Posting *</label>
                                        <input type="date" wire:model="item_posting_date"
                                            class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 dark:border-green-600 dark:bg-zinc-700 dark:text-white">
                                        @error('item_posting_date')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Material Selection -->
                        <div class="mb-6 rounded-lg border-2 border-purple-400 bg-purple-50 p-4 dark:bg-purple-900/20">
                            <label class="mb-3 block text-sm font-medium text-purple-800 dark:text-purple-300">Material
                                Mana?</label>
                            <div class="mb-4 flex flex-wrap gap-4">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" wire:model.live="item_material_mode" value="existing"
                                        class="text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700 dark:text-zinc-300">Pilih Material yang
                                        Ada</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" wire:model.live="item_material_mode" value="new"
                                        class="text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700 dark:text-zinc-300">Buat Material Baru</span>
                                </label>
                            </div>

                            @if ($item_material_mode === 'existing')
                                <div>
                                    <label
                                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Pilih
                                        Material *</label>
                                    <select wire:model="item_material_id"
                                        class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white">
                                        <option value="">-- Pilih Material --</option>
                                        @foreach ($materials as $mat)
                                            <option value="{{ $mat->id }}">{{ $mat->sap_material_code }} -
                                                {{ $mat->material_description }}</option>
                                        @endforeach
                                    </select>
                                    @error('item_material_id')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            @else
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Kode
                                            Material *</label>
                                        <input type="text" wire:model="item_new_material_code"
                                            class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white"
                                            placeholder="MAT-001">
                                        @error('item_new_material_code')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Deskripsi
                                            *</label>
                                        <input type="text" wire:model="item_new_material_desc"
                                            class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white"
                                            placeholder="Kabel XLPE 20kV">
                                        @error('item_new_material_desc')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Satuan</label>
                                        <input type="text" wire:model="item_new_material_uom"
                                            class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white"
                                            placeholder="METER">
                                    </div>
                                    <div>
                                        <label
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Kategori</label>
                                        <input type="text" wire:model="item_new_material_category"
                                            class="w-full rounded-lg border border-purple-300 bg-white px-4 py-2 dark:border-purple-600 dark:bg-zinc-700 dark:text-white"
                                            placeholder="MDU/NON-MDU/JASA">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Item Details -->
                        <div class="mb-6">
                            <h4 class="mb-3 font-medium text-zinc-800 dark:text-zinc-100">Detail Item</h4>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div
                                    class="rounded-lg border-2 border-orange-400 bg-orange-50 p-3 dark:bg-orange-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">Qty
                                        *</label>
                                    <input type="number" wire:model="item_quantity_sap" step="0.01"
                                        class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="100">
                                    @error('item_quantity_sap')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div
                                    class="rounded-lg border-2 border-orange-400 bg-orange-50 p-3 dark:bg-orange-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">Nilai
                                        (Rp)</label>
                                    <input type="number" wire:model="item_val_currency" step="0.01"
                                        class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="5000000">
                                </div>
                                <div
                                    class="rounded-lg border-2 border-orange-400 bg-orange-50 p-3 dark:bg-orange-900/20">
                                    <label
                                        class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">WBS
                                        Element</label>
                                    <input type="text" wire:model="item_wbs_element"
                                        class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 dark:border-orange-600 dark:bg-zinc-700 dark:text-white"
                                        placeholder="WBS.001.002.003">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="rounded-lg bg-orange-500 px-6 py-3 font-semibold text-white shadow-lg transition-colors hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                <span wire:loading.remove wire:target="saveItem">Simpan Item</span>
                                <span wire:loading wire:target="saveItem">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <!-- Link back to Upload SAP -->
        <div class="mt-6 text-center">
            <a href="{{ route('logistik.upload-sap') }}"
                class="text-primary-600 hover:text-primary-700 dark:text-primary-400 inline-flex items-center text-sm font-medium underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Atau gunakan Upload Excel untuk import bulk
            </a>
        </div>
    </div>
</div>
