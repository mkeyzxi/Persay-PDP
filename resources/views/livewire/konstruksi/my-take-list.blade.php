<div class="min-h-screen bg-gray-50 p-6">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Take List - Konstruksi</h1>
            <p class="mt-2 text-gray-600">Kelola progress proyek dan material</p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-4 rounded-lg border border-green-400 bg-green-100 p-4 text-green-700">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 rounded-lg border border-red-400 bg-red-100 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <!-- SECTION 1: Pilih SPK & Header Info -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800">
                <span class="text-blue-600">1.</span> Pilih Project & Data Header
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- SPK Number (Dropdown) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">SPK Number *</label>
                    <select wire:model.live="spk_number"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih SPK Number --</option>
                        @foreach ($availableProjects as $proj)
                            <option value="{{ $proj->spk_number }}">{{ $proj->spk_number }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- WBS Number (Auto-populated, Read Only) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">WBS Number</label>
                    <input type="text" wire:model="wbs_number" readonly
                        class="w-full rounded-lg border border-gray-200 bg-gray-100 px-4 py-2 text-gray-600"
                        placeholder="Otomatis dari SPK">
                </div>

                <!-- Project Name (Read Only) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Nama Proyek</label>
                    <input type="text" wire:model="project_name" readonly
                        class="w-full rounded-lg border border-gray-200 bg-gray-100 px-4 py-2 text-gray-600"
                        placeholder="Otomatis dari SPK">
                </div>

                <!-- Vendor Name (Read Only) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Nama Vendor</label>
                    <input type="text" wire:model="vendor_name" readonly
                        class="w-full rounded-lg border border-gray-200 bg-gray-100 px-4 py-2 text-gray-600"
                        placeholder="Otomatis dari SPK">
                </div>

                <!-- Location (Editable) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Lokasi Detail</label>
                    <input type="text" wire:model="location"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan lokasi proyek">
                </div>

                <!-- Contract Value (Editable) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Nilai Kontrak (Rp)</label>
                    <input type="number" wire:model="contract_value"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                        placeholder="0">
                </div>

                <!-- Contract Start Date (Editable) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Tanggal Mulai Kontrak</label>
                    <input type="date" wire:model="contract_start_date"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Contract End Date (Editable) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Tanggal Berakhir Kontrak</label>
                    <input type="date" wire:model="contract_end_date"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Target Completion Date (Editable) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Target Penyelesaian</label>
                    <input type="date" wire:model="target_completion_date"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- BASTP Date (Editable) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Realisasi BASTP</label>
                    <input type="date" wire:model="bastp_date"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- SLO Date (Editable) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Tanggal SLO</label>
                    <input type="date" wire:model="slo_date"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Progress Percent (Slider) -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Progress:
                        {{ $progress_percent }}%</label>
                    <input type="range" wire:model.live="progress_percent" min="0" max="100"
                        class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-200">
                    <div class="mt-2 h-2.5 w-full rounded-full bg-gray-200">
                        <div class="h-2.5 rounded-full bg-blue-600 transition-all duration-300"
                            style="width: {{ $progress_percent }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Constraint Note (Full Width) -->
            <div class="mt-4">
                <label class="mb-1 block text-sm font-medium text-gray-700">Kendala / Catatan</label>
                <textarea wire:model="constraint_note" rows="3"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                    placeholder="Jelaskan kendala yang dihadapi (jika ada)"></textarea>
            </div>
        </div>

        <!-- SECTION 2: Material Table -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800">
                <span class="text-blue-600">2.</span> Data Material
            </h2>

            @if (count($material_inputs) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    No</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Kode Material</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Nama Material</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Qty SAP</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    WBS Element</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Qty Terpasang</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    No. Asset</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @php $no = 1; @endphp
                            @foreach ($material_inputs as $itemId => $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900">{{ $no++ }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                                        {{ $item['material_code'] }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                                        {{ $item['material_name'] }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                                        {{ number_format($item['quantity_sap'], 2) }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600">
                                        {{ $item['wbs_element'] ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <input type="number" step="0.01"
                                            wire:model="material_inputs.{{ $itemId }}.quantity_installed"
                                            class="w-24 rounded border border-gray-300 px-2 py-1 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                            placeholder="0">
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <input type="text"
                                            wire:model="material_inputs.{{ $itemId }}.asset_number"
                                            class="w-32 rounded border border-gray-300 px-2 py-1 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                            placeholder="No. Asset">
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <input type="text"
                                            wire:model="material_inputs.{{ $itemId }}.remarks"
                                            class="w-40 rounded border border-gray-300 px-2 py-1 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                            placeholder="Keterangan">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="mt-2">Pilih SPK Number untuk melihat data material</p>
                </div>
            @endif
        </div>

        <!-- SECTION 3: Upload Dokumen -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800">
                <span class="text-blue-600">3.</span> Upload Dokumen
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Jenis Dokumen *</label>
                    <select wire:model="doc_type"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="BASTP">BASTP</option>
                        <option value="KALKIR">Kalkir</option>
                        <option value="TUG9">TUG9</option>
                        <option value="TUG10">TUG10</option>
                        <option value="LAINNYA">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">File Dokumen * (Max 10MB)</label>
                    <input type="file" wire:model="doc_file"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 file:mr-4 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                    @error('doc_file')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-end">
                    <button wire:click="uploadDocument"
                        class="w-full rounded-lg bg-green-600 px-6 py-2 font-medium text-white transition-colors hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="uploadDocument">
                            <svg class="mr-2 inline h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload Dokumen
                        </span>
                        <span wire:loading wire:target="uploadDocument">Mengupload...</span>
                    </button>
                </div>
            </div>

            <!-- List Dokumen yang sudah diupload -->
            @if (isset($documents) && count($documents) > 0)
                <div class="mt-6">
                    <h3 class="mb-3 text-lg font-medium text-gray-800">Dokumen Terupload:</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($documents as $doc)
                            <div class="flex items-center rounded-lg border border-gray-200 bg-gray-50 p-3">
                                <svg class="mr-3 h-8 w-8 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900">
                                        {{ $doc->original_filename }}</p>
                                    <p class="text-xs text-gray-500">{{ $doc->document_type }} •
                                        {{ $doc->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button wire:click="saveProgress"
                class="rounded-lg bg-blue-600 px-8 py-3 font-semibold text-white shadow-lg transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveProgress">
                    <svg class="mr-2 inline h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Progress
                </span>
                <span wire:loading wire:target="saveProgress">Menyimpan...</span>
            </button>
        </div>
    </div>
</div>
