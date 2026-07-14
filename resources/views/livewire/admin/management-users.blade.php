<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <div class="mx-auto max-w-full">

        <!-- Header -->
        <div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 md:text-3xl dark:text-white">
                    Management Users
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-zinc-400">
                    Kelola semua pengguna sistem dalam satu dasbor
                </p>
            </div>

            <div class="flex gap-3">
                <div
                    class="rounded-lg border border-gray-100 bg-white px-4 py-2 shadow-sm dark:border-gray-700 dark:bg-zinc-800">
                    <p class="text-[10px] uppercase tracking-wider text-gray-500">Total Users</p>
                    <p class="text-lg font-bold text-[#5A6ACF]">{{ $users->total() }}</p>
                </div>
                <button wire:click="openCreateModal"
                    class="flex items-center gap-2 rounded-lg bg-[#5A6ACF] px-4 py-2 font-medium text-white shadow-sm transition-colors hover:bg-[#4a5abf]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">Tambah User</span>
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="mb-4 rounded-lg border border-green-400 bg-green-100 p-4 text-green-700 dark:border-green-600 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <!-- Main Card -->
        <div
            class="overflow-hidden rounded-xl bg-white shadow-md ring-1 ring-gray-200 dark:bg-zinc-800 dark:ring-gray-700">

            <!-- Filter Bar -->
            <div
                class="flex flex-col gap-4 border-b border-gray-100 p-4 lg:flex-row lg:items-center lg:justify-between dark:border-gray-700">

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search -->
                    <div class="relative min-w-[250px]">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Cari nama atau email..."
                            class="w-full rounded-lg border-gray-200 bg-zinc-50 py-2 pl-10 pr-4 text-sm focus:border-[#5A6ACF] focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                    </div>

                    <!-- Filter Role -->
                    <select wire:model.live="filterRole"
                        class="rounded-lg border-gray-200 bg-zinc-50 py-2 text-sm focus:border-[#5A6ACF] focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="logistik">Logistik</option>
                        <option value="konstruksi">Konstruksi</option>
                        <option value="akuntansi">Akuntansi</option>
                    </select>

                    <!-- Filter Status -->
                    <select wire:model.live="filterStatus"
                        class="rounded-lg border-gray-200 bg-zinc-50 py-2 text-sm focus:border-[#5A6ACF] focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <!-- Per Page -->
                    <select wire:model.live="perPage"
                        class="rounded-lg border-gray-200 bg-zinc-50 py-2 text-sm focus:border-[#5A6ACF] focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                        <option value="10">10 Baris</option>
                        <option value="25">25 Baris</option>
                        <option value="50">50 Baris</option>
                    </select>

                    @if ($search || $filterRole || $filterStatus)
                        <button wire:click="resetFilter"
                            class="flex items-center gap-1 text-sm font-medium text-red-500 transition-colors hover:text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset
                        </button>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500 dark:text-zinc-400">
                        Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari
                        {{ $users->total() }}
                    </span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left text-sm">
                    <thead
                        class="border-b border-gray-100 bg-zinc-50/50 text-xs uppercase tracking-wider text-gray-500 dark:border-gray-700 dark:bg-gray-800/50 dark:text-zinc-400">
                        <tr>
                            <th class="px-4 py-4 font-semibold">No</th>
                            <th class="px-4 py-4 font-semibold">Nama</th>
                            <th class="px-4 py-4 font-semibold">Email</th>
                            <th class="px-4 py-4 text-center font-semibold">Role</th>
                            <th class="px-4 py-4 text-center font-semibold">Status</th>
                            <th class="px-4 py-4 font-semibold">Tanggal Daftar</th>
                            <th class="px-4 py-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700 dark:divide-gray-700 dark:text-zinc-300">
                        @forelse($users as $index => $user)
                            <tr class="group transition-colors hover:bg-blue-50/30 dark:hover:bg-blue-900/10">
                                <td class="px-4 py-4 font-medium text-gray-500">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-full bg-[#5A6ACF]/10 font-semibold text-[#5A6ACF]">
                                            {{ $user->initials() }}
                                        </div>
                                        <div>
                                            <div
                                                class="font-bold text-gray-900 transition-colors group-hover:text-[#5A6ACF] dark:text-white">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @php
                                        $roleClass = match ($user->role) {
                                            'admin' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                            'logistik'
                                                => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'konstruksi'
                                                => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                            'akuntansi'
                                                => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                            default => 'bg-gray-100 text-gray-600 dark:bg-zinc-700 dark:text-zinc-400',
                                        };
                                    @endphp
                                    <span
                                        class="{{ $roleClass }} rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $user->role ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button wire:click="toggleStatus({{ $user->id }})"
                                        class="group/status relative inline-flex cursor-pointer items-center">
                                        @if ($user->status === 'active')
                                            <span
                                                class="rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-green-700 transition-all hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400">
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-600 transition-all hover:bg-gray-200 dark:bg-zinc-700 dark:text-zinc-400">
                                                Inactive
                                            </span>
                                        @endif
                                    </button>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Detail -->
                                        <button wire:click="openDetailModal({{ $user->id }})"
                                            class="rounded-lg p-2 text-blue-500 transition-colors hover:bg-blue-100 dark:hover:bg-blue-900/30"
                                            title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <!-- Edit -->
                                        <button wire:click="openEditModal({{ $user->id }})"
                                            class="rounded-lg p-2 text-amber-500 transition-colors hover:bg-amber-100 dark:hover:bg-amber-900/30"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <!-- Delete -->
                                        <button wire:click="openDeleteModal({{ $user->id }})"
                                            class="rounded-lg p-2 text-red-500 transition-colors hover:bg-red-100 dark:hover:bg-red-900/30"
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="rounded-full bg-zinc-50 p-4 dark:bg-gray-800">
                                            <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 font-medium text-gray-500 dark:text-zinc-400">Tidak ada user
                                            yang ditemukan</p>
                                        @if ($search || $filterRole || $filterStatus)
                                            <p class="mt-1 text-sm text-gray-400">Coba ubah filter pencarian Anda</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="border-t border-gray-100 bg-zinc-50/50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800/30">
                {{ $users->links() }}
            </div>
        </div>

    </div>

    <!-- Create/Edit Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/50 p-4">
            <div class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl dark:bg-zinc-800"
                @click.away="$wire.closeModal()">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $isEditing ? 'Edit User' : 'Tambah User Baru' }}
                    </h3>
                    <button wire:click="closeModal"
                        class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Nama
                                *</label>
                            <input type="text" wire:model="name"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-[#5A6ACF] focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                placeholder="Nama lengkap">
                            @error('name')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Email
                                *</label>
                            <input type="email" wire:model="email"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-[#5A6ACF] focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                placeholder="email@example.com">
                            @error('email')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">
                                Password {{ $isEditing ? '(Kosongkan jika tidak diubah)' : '*' }}
                            </label>
                            <input type="password" wire:model="password"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-[#5A6ACF] focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                placeholder="••••••••">
                            @error('password')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Konfirmasi
                                Password</label>
                            <input type="password" wire:model="password_confirmation"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-[#5A6ACF] focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white"
                                placeholder="••••••••">
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Role
                                *</label>
                            <select wire:model="role"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-[#5A6ACF] focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="logistik">Logistik</option>
                                <option value="konstruksi">Konstruksi</option>
                                <option value="akuntansi">Akuntansi</option>
                            </select>
                            @error('role')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-zinc-300">Status
                                *</label>
                            <select wire:model="status"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-[#5A6ACF] focus:ring-2 focus:ring-[#5A6ACF]/20 dark:border-zinc-700 dark:bg-zinc-700 dark:text-white">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" wire:click="closeModal"
                            class="rounded-lg border border-gray-300 px-4 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-100 dark:border-zinc-600 dark:text-zinc-300 dark:hover:bg-zinc-700">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-lg bg-[#5A6ACF] px-4 py-2 font-medium text-white transition-colors hover:bg-[#4a5abf]">
                            <span wire:loading.remove wire:target="save">
                                {{ $isEditing ? 'Simpan Perubahan' : 'Tambah User' }}
                            </span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Detail Modal -->
    @if ($showDetailModal && $selectedUser)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/50 p-4">
            <div class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl dark:bg-zinc-800"
                @click.away="$wire.closeModal()">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Detail User
                    </h3>
                    <button wire:click="closeModal"
                        class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex flex-col items-center">
                    <div
                        class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-[#5A6ACF]/10 text-3xl font-bold text-[#5A6ACF]">
                        {{ $selectedUser->initials() }}
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $selectedUser->name }}</h4>
                    <p class="text-gray-500 dark:text-zinc-400">{{ $selectedUser->email }}</p>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="flex justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-700/50">
                        <span class="text-gray-600 dark:text-zinc-400">ID</span>
                        <span class="font-semibold text-gray-900 dark:text-white">#{{ $selectedUser->id }}</span>
                    </div>
                    <div class="flex justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-700/50">
                        <span class="text-gray-600 dark:text-zinc-400">Role</span>
                        <span
                            class="rounded-full bg-[#5A6ACF]/10 px-2 py-0.5 text-sm font-semibold uppercase text-[#5A6ACF]">
                            {{ $selectedUser->role ?? '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-700/50">
                        <span class="text-gray-600 dark:text-zinc-400">Status</span>
                        @if ($selectedUser->status === 'active')
                            <span
                                class="rounded-full bg-green-100 px-2 py-0.5 text-sm font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                Active
                            </span>
                        @else
                            <span
                                class="rounded-full bg-gray-100 px-2 py-0.5 text-sm font-semibold text-gray-600 dark:bg-zinc-700 dark:text-zinc-400">
                                Inactive
                            </span>
                        @endif
                    </div>
                    <div class="flex justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-700/50">
                        <span class="text-gray-600 dark:text-zinc-400">Email Verified</span>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            {{ $selectedUser->email_verified_at ? $selectedUser->email_verified_at->format('d/m/Y H:i') : 'Belum Verifikasi' }}
                        </span>
                    </div>
                    <div class="flex justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-700/50">
                        <span class="text-gray-600 dark:text-zinc-400">Tanggal Daftar</span>
                        <span
                            class="font-semibold text-gray-900 dark:text-white">{{ $selectedUser->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between rounded-lg bg-zinc-50 p-3 dark:bg-zinc-700/50">
                        <span class="text-gray-600 dark:text-zinc-400">Terakhir Diupdate</span>
                        <span
                            class="font-semibold text-gray-900 dark:text-white">{{ $selectedUser->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button wire:click="closeModal"
                        class="rounded-lg bg-[#5A6ACF] px-4 py-2 font-medium text-white transition-colors hover:bg-[#4a5abf]">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/50 p-4">
            <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-zinc-800">
                <div class="mb-4 flex items-center justify-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <h3 class="mb-2 text-center text-xl font-bold text-gray-900 dark:text-white">
                    Hapus User?
                </h3>
                <p class="mb-6 text-center text-gray-500 dark:text-zinc-400">
                    Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex justify-center gap-3">
                    <button wire:click="closeModal"
                        class="rounded-lg border border-gray-300 px-4 py-2 font-medium text-gray-700 transition-colors hover:bg-gray-100 dark:border-zinc-600 dark:text-zinc-300 dark:hover:bg-zinc-700">
                        Batal
                    </button>
                    <button wire:click="delete"
                        class="rounded-lg bg-red-500 px-4 py-2 font-medium text-white transition-colors hover:bg-red-600">
                        <span wire:loading.remove wire:target="delete">Ya, Hapus</span>
                        <span wire:loading wire:target="delete">Menghapus...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
