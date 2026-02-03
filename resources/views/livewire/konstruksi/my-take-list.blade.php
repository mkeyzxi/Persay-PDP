<div class="min-h-screen bg-zinc-50 p-6 transition-colors dark:bg-zinc-900">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">My Take List - Konstruksi</h1>
            <p class="mt-2 text-zinc-600 dark:text-zinc-400">Kelola progress proyek dan material</p>
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
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
            <h2
                class="mb-4 border-b border-zinc-200 pb-2 text-xl font-semibold text-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                <span class="text-primary-500">1.</span> Pilih Project & Data Header
            </h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- SPK Number (Dropdown) -->
                <div class="border-primary-500 bg-primary-50 dark:bg-primary-900/20 rounded-lg border-2 p-3">
                    <label class="text-primary-800 dark:text-primary-300 mb-1 block text-sm font-medium">Nomor SPBJ/SPK
                        *</label>
                    <select wire:model.lazy="spk_number"
                        class="border-primary-300 focus:border-primary-500 focus:ring-primary-500 dark:border-primary-600 w-full rounded-lg border bg-white px-4 py-2 focus:ring-2 dark:bg-zinc-700 dark:text-zinc-100">
                        <option value="">PILIH NOMOR KONTRAK</option>
                        @foreach ($availableProjects as $proj)
                            <option value="{{ $proj->spk_number }}">{{ $proj->spk_number }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- WBS Number -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Nomor WBS</label>
                    <input type="text" wire:model="wbs_number" readonly
                        class="w-full rounded-lg border border-green-300 bg-green-100 px-4 py-2 text-green-700 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Terisi Otomatis">
                    <span class="mt-1 text-xs text-green-600 dark:text-green-400">Terisi Otomatis dari SPK</span>
                </div>

                <!-- Judul Pekerjaan -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Judul
                        Pekerjaan</label>
                    <input type="text" wire:model="project_name"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="masukkan judul pekerjaan">
                </div>

                <!-- Nama Vendor -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Nama
                        Vendor</label>
                    <input type="text" wire:model="vendor_name"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="masukkan nama vendor">
                </div>

                <!-- Lokasi -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Lokasi</label>
                    <input type="text" wire:model="location"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="masukkan lokasi">
                </div>

                <!-- Nilai Kontrak -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Nilai Kontrak
                        (Rp)</label>
                    <input type="number" wire:model="contract_value"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="masukkan nilai kontrak">
                </div>

                <!-- Tanggal Kontrak -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Tanggal
                        Kontrak</label>
                    <input type="date" wire:model="contract_start_date"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100">
                </div>

                <!-- Tanggal Selesai -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Tanggal
                        Selesai</label>
                    <input type="date" wire:model="contract_end_date"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100">
                </div>

                <!-- Kategori -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Kategori</label>
                    <select wire:model="category"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
                        <option value="">Pilih Kategori</option>
                        <option value="MDU">MDU</option>
                        <option value="NON-MDU">NON-MDU</option>
                        <option value="JASA">JASA</option>
                    </select>
                </div>

                <!-- Kategori PDP -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Kategori
                        PDP</label>
                    <select wire:model="pdp_category"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
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
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Tindak
                        Lanjut</label>
                    <select wire:model="follow_up_code"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
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
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Target
                        Penyelesaian</label>
                    <input type="date" wire:model="target_completion_date"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
                </div>

                <!-- Tanggal SLO -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Tanggal SLO</label>
                    <input type="date" wire:model="slo_date"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
                </div>

                <!-- Progress Slider -->
                @if ($spk_number !== null)
                    <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                        <div class="mb-1 flex items-center justify-between">
                            <label class="text-sm font-medium text-green-800 dark:text-green-300">Progress</label>
                            <span class="text-sm font-bold text-green-700 dark:text-green-400">
                                {{ $proggress_percent }}%
                            </span>
                        </div>

                        <input type="range" min="0" max="100" wire:model.live="proggress_percent"
                            class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-green-200 accent-green-600 dark:bg-green-800"
                            value="{{ $proggress_percent }}">

                        <div class="mt-1 flex justify-between text-xs text-green-600 dark:text-green-400">
                            <span>0%</span>
                            <span>50%</span>
                            <span>100%</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kendala Note -->
            <div class="mt-4 rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Kendala /
                    Catatan</label>
                <textarea wire:model="constraint_note" rows="3"
                    class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100"
                    placeholder="Jelaskan kendala yang dihadapi (jika ada)"></textarea>
            </div>
        </div>

        <!-- SECTION 2: Material Table -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
            <h2
                class="mb-4 border-b border-zinc-200 pb-2 text-xl font-semibold text-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                <span class="text-primary-500">2.</span> Data Material
            </h2>

            @if (count($material_inputs) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
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
                                    class="bg-yellow-400 px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-yellow-900 dark:bg-yellow-500/80">
                                    <div>FISIK TERPASANG</div>
                                    <div class="mt-1 text-[9px] font-bold italic">Input Manual</div>
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    <div>SELISIH</div>
                                </th>
                                <th
                                    class="bg-yellow-400 px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-yellow-900 dark:bg-yellow-500/80">
                                    <div>NILAI PDP</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-800">
                            @php $no = 1; @endphp
                            @foreach ($material_inputs as $itemId => $item)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                    <td
                                        class="whitespace-nowrap px-3 py-3 text-center text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $no++ }}</td>
                                    <td
                                        class="whitespace-nowrap px-3 py-3 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $item['posting_date'] ?? '-' }}</td>
                                    <td
                                        class="whitespace-nowrap px-3 py-3 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $item['sap_doc_no'] ?? '-' }}</td>
                                    <td
                                        class="whitespace-nowrap px-3 py-3 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $item['material_code'] ?? '-' }}</td>
                                    <td class="px-3 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $item['material_name'] ?? '-' }}</td>
                                    <td
                                        class="whitespace-nowrap px-3 py-3 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ number_format($item['quantity_sap'], 2) ?? '-' }}</td>
                                    <td
                                        class="whitespace-nowrap bg-yellow-50 px-3 py-3 text-center dark:bg-yellow-900/20">
                                        <input type="number" step="0.01"
                                            wire:model.live="material_inputs.{{ $itemId }}.quantity_installed"
                                            class="w-24 rounded border-2 border-yellow-400 ...">

                                    </td>
                                    <td
                                        class="{{ ($item['selisih'] ?? 0) > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }} whitespace-nowrap px-3 py-3 text-center text-sm font-medium">
                                        {{ number_format($item['selisih'] ?? 0, 2) }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap bg-yellow-50 px-3 py-3 text-center text-sm text-zinc-600 dark:bg-yellow-900/20 dark:text-zinc-300">
                                        Rp {{ number_format($item['val_currency'] ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-8 text-center text-zinc-500 dark:text-zinc-400">
                    <p class="mt-2">Pilih SPK Number untuk melihat data material</p>
                </div>
            @endif
        </div>

        <!-- SECTION 3: Upload Dokumen -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
            <h2
                class="mb-4 border-b border-zinc-200 pb-2 text-xl font-semibold text-zinc-800 dark:border-zinc-700 dark:text-zinc-100">
                <span class="text-primary-500">3.</span> Upload Dokumen
            </h2>

            <!-- Form Upload Single -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Jenis Dokumen
                        *</label>
                    <select wire:model="doc_type"
                        class="focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border border-zinc-300 bg-white px-4 py-2 focus:ring-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100">
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
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">File Dokumen * (Max
                        10MB)</label>
                    <input type="file" wire:model="doc_file"
                        class="file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 focus:border-primary-500 focus:ring-primary-500 dark:file:bg-primary-900/50 dark:file:text-primary-300 w-full rounded-lg border border-zinc-300 px-4 py-2 file:mr-4 file:rounded-full file:border-0 file:px-4 file:py-2 file:text-sm file:font-semibold focus:ring-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100">
                    @error('doc_file')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-end">
                    <button wire:click="uploadDocument" type="button"
                        class="w-full rounded-lg bg-green-600 px-6 py-2 font-medium text-white transition-colors hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-700 dark:hover:bg-green-600 dark:focus:ring-offset-zinc-800"
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
                    <h3 class="mb-3 text-lg font-medium text-zinc-800 dark:text-zinc-100">Dokumen Terupload:</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($uploadedDocuments as $doc)
                            <div
                                class="flex items-center rounded-lg border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-700 dark:bg-zinc-700/50">
                                <svg class="mr-3 h-8 w-8 flex-shrink-0 text-blue-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $doc->original_filename }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
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
                class="bg-primary-500 hover:bg-primary-600 focus:ring-primary-500 rounded-lg px-8 py-3 font-semibold text-white shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-zinc-800"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveProgress">
                    Simpan Progress
                </span>
                <span wire:loading wire:target="saveProgress">Menyimpan...</span>
            </button>
        </div>
    </div>
</div>
