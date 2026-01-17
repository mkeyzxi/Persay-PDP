<div class="min-h-screen bg-gray-50 p-6 transition-colors dark:bg-[#1e1e2e]">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Take List - Konstruksi</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Kelola progress proyek dan material</p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div
                class="mb-4 rounded-lg border border-green-400 bg-green-100 p-4 text-green-700 dark:border-green-600 dark:bg-green-900/30 dark:text-green-400">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-4 rounded-lg border border-red-400 bg-red-100 p-4 text-red-700 dark:border-red-600 dark:bg-red-900/30 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- SECTION 1: Pilih SPK & Header Info -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-[#2d2d3d]">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-gray-600 dark:text-white">
                <span class="text-primary-500">1.</span> Pilih Project & Data Header
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- SPK Number (Dropdown) -->
                <div class="border-primary-500 bg-primary-50 dark:bg-primary-900/20 rounded-lg border-2 p-3">
                    <label class="text-primary-800 dark:text-primary-300 mb-1 block text-sm font-medium">Nomor SPBJ/SPK
                        *</label>
                    <select wire:model.lazy="spk_number"
                        class="border-primary-300 dark:border-primary-600 focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border bg-white px-4 py-2 focus:ring-2 dark:bg-gray-700 dark:text-white">
                        <option value="">PILIH NOMOR KONTRAK</option>
                        @foreach ($availableProjects as $proj)
                            <option value="{{ $proj->spk_number }}">{{ $proj->spk_number }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- WBS Number -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Nomor WBS</label>
                    <input type="text" wire:model="wbs_number" readonly
                        class="w-full rounded-lg border border-green-300 bg-green-100 px-4 py-2 text-green-700"
                        placeholder="Terisi Otomatis">
                    <span class="mt-1 text-xs text-green-600">Terisi Otomatis dari SPK</span>
                </div>

                <!-- Judul Pekerjaan -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Judul Pekerjaan</label>
                    <input type="text" wire:model="project_name"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="masukkan judul pekerjaan">
                </div>

                <!-- Nama Vendor -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Nama Vendor</label>
                    <input type="text" wire:model="vendor_name"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="masukkan nama vendor">
                </div>

                <!-- Lokasi -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Lokasi</label>
                    <input type="text" wire:model="location"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="masukkan lokasi">
                </div>

                <!-- Nilai Kontrak -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Nilai Kontrak (Rp)</label>
                    <input type="number" wire:model="contract_value"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="masukkan nilai kontrak">
                </div>

                <!-- Tanggal Kontrak -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Tanggal Kontrak</label>
                    <input type="date" wire:model="contract_start_date"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500">
                </div>

                <!-- Tanggal Selesai -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Tanggal Selesai</label>
                    <input type="date" wire:model="contract_end_date"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500">
                </div>

                <!-- Kategori -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Kategori</label>
                    <select wire:model="category"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                        <option value="">Pilih Kategori</option>
                        <option value="MDU">MDU</option>
                        <option value="NON-MDU">NON-MDU</option>
                        <option value="JASA">JASA</option>
                    </select>
                </div>

                <!-- Kategori PDP -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Kategori PDP</label>
                    <select wire:model="pdp_category"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                        <option value="">Pilih Kategori PDP</option>
                        <option value="D1.1">D1.1</option>
                        <option value="D1.2">D1.2</option>
                        <option value="D1.3">D1.3</option>
                        <option value="D2">D2</option>
                        <option value="D3.1">D3.1</option>
                        <option value="D3.2">D3.2</option>
                        <option value="D3.3">D3.3</option>
                        <option value="D3.4">D3.4</option>
                        <option value="D4">D4</option>
                        <option value="D5">D5</option>
                    </select>
                </div>

                <!-- Tindak Lanjut -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Tindak Lanjut</label>
                    <select wire:model="follow_up_code"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                        <option value="">Pilih Tindak Lanjut</option>
                        <option value="TL-1">TL-1</option>
                        <option value="TL-2">TL-2</option>
                        <option value="TL-3">TL-3</option>
                        <option value="TL-4">TL-4</option>
                        <option value="TL-5">TL-5</option>
                        <option value="TL-6">TL-6</option>
                        <option value="TL-7">TL-7</option>
                    </select>
                </div>

                <!-- Target Penyelesaian -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Target Penyelesaian</label>
                    <input type="date" wire:model="target_completion_date"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Tanggal SLO -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Tanggal SLO</label>
                    <input type="date" wire:model="slo_date"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                </div>



                   @if($spk_number !== null)
    <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
        <div class="flex justify-between items-center mb-1">
            <label class="text-sm font-medium text-green-800">Progress</label>
            <span class="text-sm font-bold text-green-700">
                {{ $proggress_percent }}%
            </span>
        </div>

        <input
            type="range"
            min="0"
            max="100"
            wire:model.live="proggress_percent"
            class="w-full h-2 bg-green-200 rounded-lg appearance-none cursor-pointer accent-green-600"
            value="{{ $proggress_percent }}"
        >

        <div class="flex justify-between text-xs text-green-600 mt-1">
            <span>0%</span>
            <span>50%</span>
            <span>100%</span>
        </div>
    </div>
@endif


                </div>
            </div>

            <!-- Kendala Note -->
            <div class="mt-4 rounded-lg border-2 border-green-500 bg-green-50 p-3">
                <label class="mb-1 block text-sm font-medium text-green-800">Kendala / Catatan</label>
                <textarea wire:model="constraint_note" rows="3"
                    class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500"
                    placeholder="Jelaskan kendala yang dihadapi (jika ada)"></textarea>
            </div>
        </div>

        <!-- SECTION 2: Material Table -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-[#2d2d3d]">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-gray-600 dark:text-white">
                <span class="text-primary-500">2.</span> Data Material
            </h2>

            @if (count($material_inputs) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-primary-500">
                            <tr>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    No</th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    <div>TANGGAL</div>
                                    <div class="text-[10px] font-normal">(PENGINPUTAN PDP DI SAP)</div>
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    <div>REFF DOKUMEN</div>
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    <div>NOMOR MATERIAL</div>
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    <div>NAMA MATERIAL/JASA</div>
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    <div>FISIK KELUAR</div>
                                </th>
                                <th
                                    class="bg-yellow-400 px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-yellow-900">
                                    <div>FISIK TERPASANG</div>
                                    <div class="mt-1 text-[9px] font-bold italic">Input Manual</div>
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    <div>SELISIH</div>
                                </th>
                                <th
                                    class="bg-yellow-400 px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-yellow-900">
                                    <div>NILAI PDP</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-600 dark:bg-[#2d2d3d]">
                            @php $no = 1; @endphp
                            @foreach ($material_inputs as $itemId => $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="whitespace-nowrap px-3 py-3 text-center text-sm text-gray-900">
                                        {{ $no++ }}</td>
                                    <td class="whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600">
                                        {{ $item['posting_date'] ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600">
                                        {{ $item['sap_doc_no'] ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600">
                                        {{ $item['material_code'] }}</td>
                                    <td class="px-3 py-3 text-sm text-gray-600">{{ $item['material_name'] }}</td>
                                    <td class="whitespace-nowrap px-3 py-3 text-center text-sm text-gray-600">
                                        {{ number_format($item['quantity_sap'], 2) }}</td>
                                    <td class="whitespace-nowrap bg-yellow-50 px-3 py-3 text-center">
                                        <input type="number" step="0.01"
                                            wire:model.live="material_inputs.{{ $itemId }}.quantity_installed"
                                            class="w-24 rounded border-2 border-yellow-400 bg-yellow-50 px-2 py-1 text-center text-sm focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                                            placeholder="0">
                                    </td>
                                    <td
                                        class="{{ ($item['selisih'] ?? 0) > 0 ? 'text-red-600' : 'text-green-600' }} whitespace-nowrap px-3 py-3 text-center text-sm font-medium">
                                        {{ number_format($item['selisih'] ?? 0, 2) }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap bg-yellow-50 px-3 py-3 text-center text-sm text-gray-600">
                                        Rp {{ number_format($item['val_currency'] ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-8 text-center text-gray-500 dark:text-gray-400">
                    <p class="mt-2">Pilih SPK Number untuk melihat data material</p>
                </div>
            @endif
        </div>

        <!-- SECTION 3: Upload Dokumen -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-[#2d2d3d]">
            <h2 class="mb-4 border-b pb-2 text-xl font-semibold text-gray-800 dark:border-gray-600 dark:text-white">
                <span class="text-primary-500">3.</span> Upload Dokumen
            </h2>

            <!-- Form Upload Single -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Dokumen
                        *</label>
                    <select wire:model="doc_type"
                        class="focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border border-gray-300 px-4 py-2 focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Jenis</option>
                        <option value="BASTP">BASTP</option>
                        <option value="KALKIR">Kalkir</option>
                        <option value="TUG9">TUG9</option>
                        <option value="TUG10">TUG10</option>
                        <option value="LAINNYA">Lainnya</option>
                    </select>
                    @error('doc_type')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">File Dokumen * (Max
                        10MB)</label>
                    <input type="file" wire:model="doc_file"
                        class="file:bg-primary-50 file:text-primary-700 dark:file:bg-primary-900/50 dark:file:text-primary-300 hover:file:bg-primary-100 focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border border-gray-300 px-4 py-2 file:mr-4 file:rounded-full file:border-0 file:px-4 file:py-2 file:text-sm file:font-semibold focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('doc_file')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-end">
                    <button wire:click="uploadDocument" type="button"
                        class="w-full rounded-lg bg-green-600 px-6 py-2 font-medium text-white transition-colors hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-700 dark:hover:bg-green-600"
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
            @if (count($uploadedDocuments) > 0)
                <div class="mt-6">
                    <h3 class="mb-3 text-lg font-medium text-gray-800 dark:text-white">Dokumen Terupload:</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($uploadedDocuments as $doc)
                            <div
                                class="flex items-center rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-600 dark:bg-gray-700">
                                <svg class="mr-3 h-8 w-8 flex-shrink-0 text-blue-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $doc->original_filename }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $doc->document_type }}
                                        @if ($doc->uploaded_at)
                                            • {{ \Carbon\Carbon::parse($doc->uploaded_at)->format('d M Y') }}
                                        @endif
                                    </p>
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
                class="bg-primary-500 hover:bg-primary-600 focus:ring-primary-500 rounded-lg px-8 py-3 font-semibold text-white shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveProgress">

                    Simpan Progress
                </span>
                <span wire:loading wire:target="saveProgress">Menyimpan...</span>
            </button>
        </div>
    </div>
</div>
