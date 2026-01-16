<div class="min-h-screen bg-gray-50 p-6 transition-colors dark:bg-[#1e1e2e]">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Upload SAP - Logistik</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Upload file Excel SAP atau input data manual</p>
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

        <!-- SECTION 1: Upload File SAP -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-[#2d2d3d]">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-gray-600 dark:text-white">
                <span class="text-primary-500">1.</span> Upload File SAP (Excel)
            </h2>

            <form wire:submit.prevent="uploadSap">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-1">
                    <!-- File Input -->
                    <div class="border-primary-500 bg-primary-50 dark:bg-primary-900/20 rounded-lg border-2 p-3">
                        <label class="text-primary-800 dark:text-primary-300 mb-1 block text-sm font-medium">Pilih File
                            Excel *</label>
                        <input type="file" id="sapFile" wire:model="sapFile"
                            class="border-primary-300 dark:border-primary-600 file:bg-primary-500 hover:file:bg-primary-600 w-full rounded-lg border bg-white px-4 py-2 text-sm file:mr-4 file:rounded file:border-0 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white dark:bg-gray-700 dark:text-white">
                        <span class="text-primary-600 dark:text-primary-400 mt-1 text-xs">Format: .xlsx, .xls,
                            .csv</span>
                        @error('sapFile')
                            <span class="mt-1 block text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Upload Button -->
                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-primary-500 hover:bg-primary-600 focus:ring-primary-500 w-full rounded-lg px-6 py-2 font-medium text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"
                            wire:loading.attr="disabled" wire:target="sapFile, uploadSap">
                            <span wire:loading.remove wire:target="uploadSap">Upload Excel</span>
                            <span wire:loading wire:target="uploadSap">Mengupload...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- SECTION 2: Input Manual Data Project -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-[#2d2d3d]">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-gray-600 dark:text-white">
                <span class="text-primary-500">2.</span> Input Manual Data SAP
            </h2>

            <form wire:submit.prevent="save">
                <!-- Data Project -->
                <div class="mb-6">
                    <h3 class="mb-3 text-lg font-medium text-gray-800 dark:text-white">Data Project</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <!-- SPK Number -->
                        <div class="border-primary-500 bg-primary-50 dark:bg-primary-900/20 rounded-lg border-2 p-3">
                            <label class="text-primary-800 dark:text-primary-300 mb-1 block text-sm font-medium">Nomor
                                SPK *</label>
                            <input type="text" wire:model="spk_number"
                                class="border-primary-300 dark:border-primary-600 focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border bg-white px-4 py-2 focus:ring-2 dark:bg-gray-700 dark:text-white"
                                placeholder="SPK-2026-001">
                            @error('spk_number')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- WBS Number -->
                        <div class="border-primary-500 bg-primary-50 dark:bg-primary-900/20 rounded-lg border-2 p-3">
                            <label class="text-primary-800 dark:text-primary-300 mb-1 block text-sm font-medium">Nomor
                                WBS *</label>
                            <input type="text" wire:model="wbs_number"
                                class="border-primary-300 dark:border-primary-600 focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border bg-white px-4 py-2 focus:ring-2 dark:bg-gray-700 dark:text-white"
                                placeholder="WBS.001.002">
                            @error('wbs_number')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Vendor Name -->
                        <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                            <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Nama
                                Vendor</label>
                            <input type="text" wire:model="vendor_name"
                                class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-gray-700 dark:text-white"
                                placeholder="PT. Kontraktor ABC">
                            @error('vendor_name')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Unit Code -->
                        <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                            <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Unit Code
                                (BusA)</label>
                            <input type="text" wire:model="unit_code"
                                class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-gray-700 dark:text-white"
                                placeholder="5100">
                            @error('unit_code')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Fiscal Year -->
                        <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                            <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Tahun
                                Fiskal</label>
                            <input type="number" wire:model="fiscal_year"
                                class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-gray-700 dark:text-white"
                                placeholder="2026" min="2000" max="2100">
                            @error('fiscal_year')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Project Name -->
                        <div
                            class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 md:col-span-2 lg:col-span-3 dark:bg-yellow-900/20">
                            <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Nama
                                Pekerjaan (PO Text)</label>
                            <input type="text" wire:model="project_name"
                                class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Pembangunan Gardu">
                            @error('project_name')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Material Issue Header -->
                <div class="mb-6">
                    <h3 class="mb-3 text-lg font-medium text-gray-800 dark:text-white">Material Issue (Header)</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <!-- SAP Doc No -->
                        <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                            <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Nomor
                                Dokumen TUG *</label>
                            <input type="text" wire:model="sap_doc_no"
                                class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-gray-700 dark:text-white"
                                placeholder="4900012345">
                            @error('sap_doc_no')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Posting Date -->
                        <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                            <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Tanggal
                                Posting *</label>
                            <input type="date" wire:model="posting_date"
                                class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-gray-700 dark:text-white">
                            @error('posting_date')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Header Text -->
                        <div
                            class="rounded-lg border-2 border-green-500 bg-green-50 p-3 md:col-span-2 lg:col-span-3 dark:bg-green-900/20">
                            <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Keterangan
                                Header</label>
                            <textarea wire:model="header_text" rows="2"
                                class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-gray-700 dark:text-white"
                                placeholder="Keterangan tambahan..."></textarea>
                            @error('header_text')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Material Issue Item -->
                <div class="mb-6">
                    <h3 class="mb-3 text-lg font-medium text-gray-800 dark:text-white">Material Issue Item (Detail)
                    </h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Quantity SAP -->
                        <div class="rounded-lg border-2 border-orange-500 bg-orange-50 p-3 dark:bg-orange-900/20">
                            <label class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">Jumlah
                                Barang Keluar</label>
                            <input type="number" wire:model="quantity_sap" step="0.01"
                                class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-orange-600 dark:bg-gray-700 dark:text-white"
                                placeholder="100">
                            @error('quantity_sap')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Val Currency -->
                        <div class="rounded-lg border-2 border-orange-500 bg-orange-50 p-3 dark:bg-orange-900/20">
                            <label class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">Nilai
                                Rupiah</label>
                            <input type="number" wire:model="val_currency" step="0.01"
                                class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-orange-600 dark:bg-gray-700 dark:text-white"
                                placeholder="5000000">
                            @error('val_currency')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- WBS Element Item -->
                        <div class="rounded-lg border-2 border-orange-500 bg-orange-50 p-3 dark:bg-orange-900/20">
                            <label class="mb-1 block text-sm font-medium text-orange-800 dark:text-orange-300">WBS per
                                Item</label>
                            <input type="text" wire:model="item_wbs_element"
                                class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 dark:border-orange-600 dark:bg-gray-700 dark:text-white"
                                placeholder="WBS.001.002.003">
                            @error('item_wbs_element')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-primary-500 hover:bg-primary-600 focus:ring-primary-500 rounded-lg px-8 py-3 font-semibold text-white shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"
                        wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save">Simpan Data</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
