<div class="min-h-screen bg-gray-50 p-6">
    <div class="mx-auto max-w-7xl">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Take List - Akuntansi</h1>
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
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Nomor SPBJ/SPK *</label>
                    <select wire:model.lazy="spk_number"
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
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
                    <input type="text" readonly wire:model="project_name"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="Terisi otomatis ">
                </div>

                <!-- Nama Vendor -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Nama Vendor</label>
                    <input type="text" wire:model="vendor_name"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="Terisi otomatis " readonly>
                </div>

                <!-- Lokasi -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Lokasi</label>
                    <input type="text" wire:model="location"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="Terisi otomatis" readonly>
                </div>

                <!-- Nilai Kontrak -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Nilai Kontrak (Rp)</label>
                    <input type="number" wire:model="contract_value"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="Terisi otomatis" readonly>
                </div>

                <!-- Tanggal Kontrak -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Tanggal Kontrak</label>
                    <input type="text" wire:model="contract_start_date"
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        readonly placeholder="Terisi otomatis">
                </div>

                <!-- Tanggal Selesai -->
                <div class="rounded-lg border-2 border-yellow-500 bg-yellow-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-yellow-800">Tanggal Selesai</label>
                    <input type="text" wire:model="contract_end_date" readonly
                        class="w-full rounded-lg border border-yellow-300 bg-white px-4 py-2 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500"
                        placeholder="Terisi otomatis">
                </div>

                <!-- Kategori -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Kategori</label>
                    <input type="text" wire:model="category" placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Kategori PDP -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Kategori PDP</label>
                    <input type="text" wire:model="pdp_category"
                        placeholder="Terisi otomatis readonly
                        class="w-full rounded-lg border
                        border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Tindak Lanjut -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Tindak Lanjut</label>
                    <input type="text" wire:model="follow_up_code" placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Target Penyelesaian -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium  text-green-800">Target Penyelesaian</label>
                    <input type="date" wire:model="target_completion_date" placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Tanggal SLO -->
                <div class="rounded-lg border-2 border-green-500 bg-green-50 p-3">
                    <label class="mb-1 block text-sm font-medium text-green-800">Tanggal SLO</label>
                    <input type="date" wire:model="slo_date"placeholder="Terisi otomatis" readonly
                        class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <!-- Kendala Note -->
            <div class="mt-4 rounded-lg border-2 border-green-500 bg-green-50 p-3">
                <label class="mb-1 block text-sm font-medium text-green-800">Kendala / Catatan</label>
                <textarea wire:model="constraint_note" rows="3"
                    class="w-full rounded-lg border border-green-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-500"
                    placeholder="Terisi otomatis" readonly></textarea>
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
                        <thead class="bg-orange-500">
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
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @php $no = 1; @endphp
                            @foreach ($material_inputs as $itemId => $item)
                                <tr class="hover:bg-gray-50">
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
                                        {{ number_format($item['quantity_installed'], 2) }}</td>
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
                <div class="py-8 text-center text-gray-500">
                    <p class="mt-2">Pilih SPK Number untuk melihat data material</p>
                </div>
            @endif
        </div>

        <!-- SECTION 3: Upload Dokumen -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg">


            <!-- List Dokumen yang sudah diupload -->
            @if (count($uploadedDocuments) > 0)
                <div class="mt-6">
                    <h3 class="mb-3 text-lg font-medium text-gray-800">Dokumen Terupload:</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($uploadedDocuments as $doc)
                            <div class="flex items-center rounded-lg border border-gray-200 bg-gray-50 p-3">
                                <svg class="mr-3 h-8 w-8 flex-shrink-0 text-blue-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900">
                                        {{ $doc->original_filename }}</p>
                                    <p class="text-xs text-gray-500">
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


    </div>
</div>
