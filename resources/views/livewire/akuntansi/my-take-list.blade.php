<div class="min-h-screen bg-zinc-50 p-6 transition-colors dark:bg-zinc-900">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">My Take List - Akuntansi</h1>
            <p class="mt-2 text-zinc-600 dark:text-zinc-400">Kelola progress proyek dan material</p>
        </div>

        <!-- Pilih SPK & Header Info -->
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
                    <input type="text" readonly wire:model="project_name"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Terisi otomatis">
                </div>

                <!-- Nama Vendor -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Nama
                        Vendor</label>
                    <input type="text" wire:model="vendor_name"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Terisi otomatis" readonly>
                </div>

                <!-- Lokasi -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Lokasi</label>
                    <input type="text" wire:model="location"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Terisi otomatis" readonly>
                </div>

                <!-- Nilai Kontrak -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Nilai Kontrak
                        (Rp)</label>
                    <input type="number" wire:model="contract_value"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Terisi otomatis" readonly>
                </div>

                <!-- Tanggal Kontrak -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Tanggal
                        Kontrak</label>
                    <input type="text" wire:model="contract_start_date"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        readonly placeholder="Terisi otomatis">
                </div>

                <!-- Tanggal Selesai -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3 dark:bg-yellow-900/20">
                    <label class="mb-1 block text-sm font-medium text-yellow-800 dark:text-yellow-300">Tanggal
                        Selesai</label>
                    <input type="text" wire:model="contract_end_date" readonly
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 dark:border-yellow-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Terisi otomatis">
                </div>

                <!-- Kategori -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Kategori</label>
                    <input type="text" wire:model="category" placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
                </div>

                <!-- Kategori PDP -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Kategori
                        PDP</label>
                    <input type="text" wire:model="pdp_category" placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100" />
                </div>

                <!-- Tindak Lanjut -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Tindak
                        Lanjut</label>
                    <input type="text" wire:model="follow_up_code" placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
                </div>

                <!-- Target Penyelesaian -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Target
                        Penyelesaian</label>
                    <input type="date" wire:model="target_completion_date" placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
                </div>

                <!-- Tanggal SLO -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                    <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Tanggal SLO</label>
                    <input type="date" wire:model="slo_date" placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100">
                </div>
            </div>

            <!-- Kendala Note -->
            <div class="mt-4 rounded-lg border-2 border-green-500 bg-green-50 p-3 dark:bg-green-900/20">
                <label class="mb-1 block text-sm font-medium text-green-800 dark:text-green-300">Kendala /
                    Catatan</label>
                <textarea wire:model="constraint_note" rows="3"
                    class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100"
                    placeholder="Terisi otomatis" readonly></textarea>
            </div>
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
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-white">
                                    <div>SELISIH</div>
                                </th>
                                <th
                                    class="bg-yellow-400 px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-yellow-900 dark:bg-yellow-500/80">
                                    <div>NILAI PDP</div>
                                </th>
                                <th
                                    class="bg-yellow-400 px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-yellow-900 dark:bg-yellow-500/80">
                                    <div>Nomor Asset</div>
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
                                        {{ $item['material_code'] ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $item['material_name'] }}</td>
                                    <td
                                        class="whitespace-nowrap px-3 py-3 text-center text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ number_format($item['quantity_sap'], 2) }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap bg-yellow-50 px-3 py-3 text-center text-zinc-700 dark:bg-yellow-900/20 dark:text-zinc-300">
                                        {{ number_format($item['quantity_installed'], 2) }}
                                    </td>
                                    <td
                                        class="{{ ($item['selisih'] ?? 0) > 0 || ($item['selisih'] ?? 0) < 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }} whitespace-nowrap px-3 py-3 text-center text-sm font-medium">
                                        {{ number_format($item['selisih'] ?? 0, 2) }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap bg-yellow-50 px-3 py-3 text-center text-sm text-zinc-600 dark:bg-yellow-900/20 dark:text-zinc-300">
                                        Rp {{ number_format($item['val_currency'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap bg-yellow-50 px-3 py-3 text-center text-sm dark:bg-yellow-900/20">
                                        <div class="relative">
                                            <input type="text"
                                                wire:model.blur="material_inputs.{{ $itemId }}.asset_number"
                                                wire:change.debounce.500ms="updateMaterialItem({{ $itemId }})"
                                                class="{{ !empty($item['asset_number'])
                                                    ? 'border-green-300 bg-white focus:border-green-500 focus:ring-green-500 dark:border-green-600 dark:bg-zinc-700 dark:text-zinc-100'
                                                    : 'border-green-300 bg-green-200 focus:border-green-500 focus:ring-green-500 dark:border-green-600 dark:bg-green-900/30 dark:text-zinc-100' }} w-[150px] rounded-lg border px-4 py-2 pr-8 focus:ring-2"
                                                placeholder="Masukkan asset" />
                                            {{-- Loading indicator per-item --}}
                                            <div wire:loading wire:target="updateMaterialItem({{ $itemId }})"
                                                class="absolute right-2 top-1/2 -translate-y-1/2">
                                                <svg class="h-4 w-4 animate-spin text-green-500"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </div>
                                            {{-- Success indicator --}}
                                            <div wire:loading.remove
                                                wire:target="updateMaterialItem({{ $itemId }})">
                                                @if (!empty($item['asset_number']))
                                                    <span
                                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-green-500">
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
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

        <!-- Save Button -->
        <div class="mb-5 flex justify-end">
            <button wire:click="updateStatusProject" @disabled(blank($spk_number)) wire:loading.attr="disabled"
                class="bg-primary-500 hover:bg-primary-600 focus:ring-primary-500 {{ !$spk_number ? 'hidden' : 'block' }} rounded-lg px-8 py-3 font-semibold text-white shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-zinc-800">
                <span wire:loading.remove wire:target="updateStatusProject">
                    Nyatakan Selesai
                </span>
                <span wire:loading wire:target="updateStatusProject">
                    Menyimpan...
                </span>
            </button>
        </div>

        <!-- List Dokumen yang sudah diupload -->
        @if (count($uploadedDocuments) > 0)
            <div class="mb-6 rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
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
            </div>
        @endif
    </div>
</div>
