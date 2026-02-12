<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PRISAY-PDP | Project Information System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="overflow-x-hidden bg-slate-50 text-slate-900 antialiased">

    <div
        class="absolute left-1/2 top-0 -z-10 h-[600px] w-full -translate-x-1/2 bg-gradient-to-b from-indigo-100/50 to-transparent">
    </div>

    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6">
        <div class="flex items-center gap-3">

            <span class="text-xl font-bold tracking-tight text-slate-800">PRISAY<span
                    class="text-indigo-600">-PDP</span></span>
        </div>

        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold text-slate-600 transition hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-full border border-slate-200 bg-white px-6 py-2.5 text-sm font-bold shadow-sm transition hover:bg-slate-50">Log
                        In</a>
                    {{-- <a href="#fitur"
                        class="rounded-full bg-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-700">Mulai
                        Sekarang</a> --}}
                @endauth
            @endif
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-6 pb-24 pt-16 text-center  lg:text-left">
        <div class="grid items-center gap-16 lg:grid-cols-2">
            <div>
                <div
                    class="mb-6 inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-indigo-500"></span>
                    </span>
                    SISTEM MANAJEMEN PROYEK 2026
                </div>
                <h1 class="mb-6 text-5xl font-extrabold leading-[1.1] text-slate-900 lg:text-6xl">
                    Kelola Proyek <br />
                    <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Lebih
                        Akurat.</span>
                </h1>
                <p class="mx-auto mb-10 max-w-xl text-lg leading-relaxed text-slate-600 lg:mx-0">
                    Sistem integrasi terpusat untuk memantau progres fisik, material SAP, hingga validasi aset dalam
                    satu platform real-time.
                </p>
                <div class="flex flex-wrap justify-center gap-4 lg:justify-start">
                    <div
                        class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-white px-5 py-3 shadow-sm">
                        {{-- <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div> --}}
                        <span class="text-sm font-semibold text-slate-700">Integrasi SAP</span>
                    </div>
                    <div
                        class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-white px-5 py-3 shadow-sm">
                        {{-- <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div> --}}
                        <span class="text-sm font-semibold text-slate-700">Real-time Dashboard</span>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -left-10 -top-10 h-40 w-40 rounded-full bg-indigo-200/50 blur-3xl"></div>
                <div
                    class="relative transform rounded-3xl border border-slate-200 bg-white p-4 shadow-2xl transition duration-500 hover:rotate-0 lg:rotate-2">
                    <div class="mb-4 flex items-center gap-2 border-b border-slate-100 pb-4">
                        <div class="flex gap-1.5">
                            <div class="h-3 w-3 rounded-full bg-red-400"></div>
                            <div class="h-3 w-3 rounded-full bg-amber-400"></div>
                            <div class="h-3 w-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <div class="mx-auto h-4 w-32 rounded-full bg-slate-100"></div>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="h-20 rounded-2xl bg-indigo-50 p-3">
                                <div class="mb-2 h-2 w-8 rounded bg-indigo-200"></div>
                                <div class="h-4 w-12 rounded bg-indigo-400"></div>
                            </div>
                            <div class="h-20 rounded-2xl bg-slate-50 p-3">
                                <div class="mb-2 h-2 w-8 rounded bg-slate-200"></div>
                                <div class="h-4 w-12 rounded bg-slate-400"></div>
                            </div>
                            <div class="h-20 rounded-2xl bg-emerald-50 p-3">
                                <div class="mb-2 h-2 w-8 rounded bg-emerald-200"></div>
                                <div class="h-4 w-12 rounded bg-emerald-400"></div>
                            </div>
                        </div>
                        <div class="flex h-48 items-end justify-between gap-2 rounded-2xl bg-slate-50 p-4">
                            <div class="w-full rounded-t-lg bg-indigo-200" style="height: 40%"></div>
                            <div class="w-full rounded-t-lg bg-indigo-300" style="height: 60%"></div>
                            <div class="w-full rounded-t-lg bg-indigo-500" style="height: 85%"></div>
                            <div class="w-full rounded-t-lg bg-indigo-400" style="height: 50%"></div>
                            <div class="w-full rounded-t-lg bg-indigo-600" style="height: 95%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <section id="fitur" class="border-y border-slate-100 bg-white py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-3xl font-bold text-slate-900">Satu Sistem, Tiga Divisi</h2>
                <p class="mx-auto max-w-xl text-lg text-slate-500">Prisay-PDP menghubungkan setiap langkah pekerjaan
                    secara digital tanpa celah informasi.</p>
            </div>

            <div class="grid gap-8 text-left md:grid-cols-3">
                <div
                    class="rounded-[2rem] border border-slate-100 bg-slate-50/50 p-8 transition duration-300 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50">
                    <div
                        class="mb-8 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-200">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-start text-xl font-bold text-slate-900">Logistik</h3>
                    <p class="text-start text-sm leading-relaxed text-slate-600">Unggah data material dari SAP secara
                        otomatis dan kelola WBS dengan akurasi tinggi.</p>
                </div>

                <div
                    class="rounded-[2rem] border border-slate-100 bg-slate-50/50 p-8 transition duration-300 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50">
                    <div
                        class="mb-8 flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-600 text-white shadow-lg shadow-violet-200">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-start text-xl font-bold text-slate-900">Konstruksi</h3>
                    <p class="text-start text-sm leading-relaxed text-slate-600">Catat progres fisik lapangan dan
                        unggah dokumentasi langsung dari perangkat mobile.</p>
                </div>

                <div
                    class="rounded-[2rem] border border-slate-100 bg-slate-50/50 p-8 transition duration-300 hover:bg-white hover:shadow-xl hover:shadow-indigo-100/50">
                    <div
                        class="mb-8 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-200">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-3 text-start text-xl font-bold text-slate-900">Akuntansi</h3>
                    <p class="text-start text-sm leading-relaxed text-slate-600">Validasi penomoran aset dan lakukan
                        penutupan proyek dengan kelengkapan data terverifikasi.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-50 py-12">
        <div class="mx-auto max-w-7xl px-6 text-center">
            <div class="flex flex-col items-center justify-center gap-6 border-t border-slate-200 pt-12 md:flex-row">
                <p class="text-sm font-medium italic text-slate-500">© 2026 PRISAY-PDP - Project Information System</p>
                {{-- <div class="flex gap-8">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Built with Laravel
                        12</span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Livewire Flux</span>
                </div> --}}
            </div>
        </div>
    </footer>

</body>

</html>
