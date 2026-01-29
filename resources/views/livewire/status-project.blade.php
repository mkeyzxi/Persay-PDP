<div class="relative w-full h-full bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col items-center justify-center">

    <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#5a6acf] opacity-10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute bottom-4 left-4 w-12 h-12 bg-[#5a6acf] opacity-5 rounded-full pointer-events-none blur-sm"></div>

    <div class="relative z-10 text-center">
        <h3 class="text-7xl font-bold text-[#5a6acf] leading-tight">
            {{ $numberStatus }}
        </h3>

        {{-- <div class="mt-2 inline-block px-3 py-1 rounded-full bg-gray-50 border border-gray-100 "> --}}
            <span class="text-sm font-semibold text-gray-600 uppercase tracking-wide">
                {{ $projectStatus == "CLOSED" ? "Selesai" : ($projectStatus == "OPEN" ? "In Progress" : "Draft") }}
            </span>
        {{-- </div> --}}
    </div>
</div>
