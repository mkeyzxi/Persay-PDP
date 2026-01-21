<div class="">
    {{-- <div class="">
        <div class="flex items-center justify-end border-b border-gray-200 bg-white p-4">

            <input type="text" placeholder="Cari Proyek/SPK." class="md:w-60 m-4 p-2 border border-gray-300 rounded-md">
            <button class="m-4 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Cari</button>
        </div>
    </div> --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
        <table class="w-full min-w-max table-auto text-left text-sm ">
            <thead class="bg-gray-100 uppercase text-gray-600">
                <tr>
                    <th class="px-4 py-3">No SPK / Project</th>
                    <th class="px-4 py-3">Tgl Berakhir Kontrak</th>
                    <th class="px-4 py-3 text-right">Saldo PDP (Rp)</th>
                    <th class="px-4 py-3 text-center">Umur (Hari)</th>
                    <th class="px-4 py-3 text-center">Progress (%)</th>
                    <th class="px-4 py-3 text-center">Kategori</th>
                    <th class="px-4 py-3">Keterangan Kategori</th>
                    <th class="px-4 py-3">Tgl BAST</th>
                    <th class="px-4 py-3">Tgl SLO</th>
                    <th class="px-4 py-3">Kendala</th>
                    <th class="px-4 py-3 text-center">Tindak Lanjut</th>
                    <th class="px-4 py-3 text-center">Keterangan Tindak Lanjut</th>
                    <th class="px-4 py-3">Target Penyelesaian</th>
                    <th class="px-4 py-3">Remark</th>
                    <th class="px-4 py-3 text-center">Klaster Umur</th>
                    <th class="px-4 py-3 text-center">Umur (Bulan)</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse($projects as $p)
                    <tr class="border-b hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                        <td class="px-4 py-3 font-medium">
                            <div class="font-bold text-gray-800">{{ $p->spk_number }}</div>
                            <div class="text-xs text-gray-500 truncate w-48" title="{{ $p->project_name }}">
                                {{ $p->project_name }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            {{ $p->contract_end_date ? \Carbon\Carbon::parse($p->contract_end_date)->format('d/m/Y') : '-' }}
                            {{-- {{ $p->contract_end_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $p->contract_end_date)->format('d/m/Y') : '-' }} --}}
                        </td>
                        <td class="px-4 py-3 text-right font-mono font-medium text-gray-800">
                            {{ number_format($p->saldo_pdp, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{ round($p->umur_hari) }} Hari
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                            {{ $p->proggress_percent == 100 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $p->proggress_percent }}%
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center font-bold">
                            {{ $p->pdp_category ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-xs">
                            {{ $p->ket_kategori }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $p->bastp_date ? \Carbon\Carbon::parse($p->bastp_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $p->slo_date ? \Carbon\Carbon::parse($p->slo_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-3 text-red-600">
                            {{ $p->constraint_note ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{ $p->follow_up_code ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{ $p->ket_tindak_lanjut ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $p->target_completion_date ? \Carbon\Carbon::parse($p->target_completion_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td
                            class="px-4 py-3 italic   {{ $p->status == 'CLOSED' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} {{ $p->status == 'OPEN' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $p->status ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            {{ $p->klaster_umur }}
                        </td>
                        <td class="px-4 py-3 text-center font-bold">
                            @php
                                $totalHari = $p->umur_bulan;
                                $bulan = intdiv($totalHari, 30);
                                $hari = $totalHari % 30;
                            @endphp
                            {{ $bulan }} bulan {{ $hari }} hari
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="px-4 py-8 text-center text-gray-500">
                            Belum ada data project yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 px-4 py-2">
        <div>
            @foreach ($projects as $project)
                <!-- ... -->
            @endforeach
        </div>

        {{ $projects->links() }}
    </div>


</div>
