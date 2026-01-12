<div class="mx-auto max-w-4xl space-y-8 p-6">

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- ============================================ --}}
    {{-- 📁 UPLOAD FILE SAP (EXCEL) --}}
    {{-- ============================================ --}}
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-bold text-gray-800">📁 Upload File SAP (Excel)</h2>
        <form wire:submit.prevent="uploadSap">
            <div class="mb-4">
                <label for="sapFile" class="mb-2 block text-sm font-medium text-gray-700">
                    Pilih File Excel (.xlsx, .xls, .csv):
                </label>
                <input type="file" id="sapFile" wire:model="sapFile"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:rounded file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100">
                @error('sapFile')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="rounded bg-blue-600 px-4 py-2 font-bold text-white transition hover:bg-blue-700"
                wire:loading.attr="disabled" wire:target="sapFile, uploadSap">
                <span wire:loading.remove wire:target="uploadSap" class="text-gray-900">Upload Excel</span>
                <span wire:loading wire:target="uploadSap">Mengupload...</span>
            </button>
        </form>
    </div>

    {{-- ============================================ --}}
    {{-- 📝 INPUT MANUAL --}}
    {{-- ============================================ --}}
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-bold text-gray-800">📝 Input Manual Data SAP</h2>
        <form wire:submit.prevent="save">

            {{-- PROJECT (Master) --}}
            <fieldset class="mb-6 rounded border border-gray-300 p-4">
                <legend class="px-2 text-lg font-semibold text-blue-600">🏗️ Data Project</legend>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    {{-- SPK Number --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor SPK (Unloading Point)</label>
                        <input type="text" wire:model="spk_number"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: SPK-2026-001">
                        @error('spk_number')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- WBS Number --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor WBS</label>
                        <input type="text" wire:model="wbs_number"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: WBS.001.002">
                        @error('wbs_number')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Project Name --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Nama Pekerjaan (PO Text)</label>
                        <input type="text" wire:model="project_name"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: Pembangunan Gardu">
                        @error('project_name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Vendor Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Vendor</label>
                        <input type="text" wire:model="vendor_name"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: PT. Kontraktor ABC">
                        @error('vendor_name')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Unit Code --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Unit Code (BusA)</label>
                        <input type="text" wire:model="unit_code"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: 5100">
                        @error('unit_code')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Fiscal Year --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun (Fiscal Year)</label>
                        <input type="number" wire:model="fiscal_year"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: 2026" min="2000" max="2100">
                        @error('fiscal_year')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </fieldset>

            {{-- MATERIAL ISSUE (Header) --}}
            <fieldset class="mb-6 rounded border border-gray-300 p-4">
                <legend class="px-2 text-lg font-semibold text-green-600">📄 Material Issue (Header)</legend>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    {{-- SAP Doc No --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Dokumen TUG (SAP Doc No)</label>
                        <input type="text" wire:model="sap_doc_no"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: 4900012345">
                        @error('sap_doc_no')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Posting Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Posting</label>
                        <input type="date" wire:model="posting_date"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('posting_date')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Header Text --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Keterangan Header</label>
                        <textarea wire:model="header_text" rows="2"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Keterangan tambahan..."></textarea>
                        @error('header_text')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </fieldset>

            {{-- MATERIAL ISSUE ITEM (Detail) --}}
            <fieldset class="mb-6 rounded border border-gray-300 p-4">
                <legend class="px-2 text-lg font-semibold text-orange-600">📦 Material Issue Item (Detail)</legend>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    {{-- Quantity SAP --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Barang Keluar (SAP)</label>
                        <input type="number" wire:model="quantity_sap" step="0.01"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: 100">
                        @error('quantity_sap')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Val Currency --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nilai Rupiah (Val Currency)</label>
                        <input type="number" wire:model="val_currency" step="0.01"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: 5000000">
                        @error('val_currency')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- WBS Element Item --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">WBS per Item</label>
                        <input type="text" wire:model="item_wbs_element"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: WBS.001.002.003">
                        @error('item_wbs_element')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </fieldset>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="rounded bg-green-600 px-6 py-2 font-bold text-white transition hover:bg-green-700"
                    wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">💾 Simpan Data</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>

        </form>
    </div>

</div>
