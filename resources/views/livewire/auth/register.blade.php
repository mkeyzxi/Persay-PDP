<x-layouts.app :title="'Register User'">
    <div class="min-h-screen bg-zinc-50 p-6 dark:bg-zinc-900">
        <div class="mx-auto max-w-md">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Tambah User Baru</h1>
                <p class="mt-2 text-zinc-600 dark:text-zinc-400">Isi form di bawah untuk membuat akun baru</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <!-- Register Form -->
            <form method="POST" action="{{ route('register.store') }}"
                class="flex flex-col gap-6 rounded-xl bg-white p-6 shadow-lg dark:bg-zinc-800">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nama Lengkap *</label>
                    <input type="text" name="name" required autofocus autocomplete="name"
                        class="focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border border-zinc-300 bg-white px-4 py-2 focus:ring-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email *</label>
                    <input type="email" name="email" required autocomplete="email"
                        class="focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border border-zinc-300 bg-white px-4 py-2 focus:ring-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="email@example.com">
                    @error('email')
                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Password *</label>
                    <input type="password" name="password" required autocomplete="new-password"
                        class="focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border border-zinc-300 bg-white px-4 py-2 focus:ring-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Masukkan password">
                    @error('password')
                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Konfirmasi Password
                        *</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                        class="focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border border-zinc-300 bg-white px-4 py-2 focus:ring-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100"
                        placeholder="Ulangi password">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Role *</label>
                    <select name="role" required
                        class="focus:border-primary-500 focus:ring-primary-500 w-full rounded-lg border border-zinc-300 bg-white px-4 py-2 focus:ring-2 dark:border-zinc-600 dark:bg-zinc-700 dark:text-zinc-100">
                        <option value="">Pilih Role</option>
                        <option value="logistik">Logistik</option>
                        <option value="konstruksi">Konstruksi</option>
                        <option value="akuntansi">Akuntansi</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role')
                        <span class="mt-1 text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-primary-500 hover:bg-primary-600 focus:ring-primary-500 w-full rounded-lg px-8 py-3 font-semibold text-white shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-zinc-800">
                    Buat Akun
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
