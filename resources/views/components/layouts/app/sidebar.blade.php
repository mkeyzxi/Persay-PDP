@props(['title' => null])

<flux:sidebar sticky collapsible="mobile"
    class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    {{-- sesuaikan --}}
    <flux:sidebar.header>
        <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
        <flux:sidebar.collapse class="lg:hidden" />
    </flux:sidebar.header>

    <flux:sidebar.nav>
        {{-- Dashboard - Selalu tampil untuk semua role --}}
        <flux:sidebar.group :heading="__('Menu Utama')" class="grid">
            <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>
                {{ __('Dashboard') }}
            </flux:sidebar.item>
        </flux:sidebar.group>

        {{-- Menu Logistik --}}
        @if (auth()->user()?->role === 'logistik')
            <flux:sidebar.group :heading="__('Input Data')" class="grid">
                <flux:sidebar.item icon="cloud-arrow-up" :href="route('logistik.upload-sap')"
                    :current="request()->routeIs('logistik.upload-sap')" wire:navigate>
                    {{ __('Upload SAP') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="pencil-square" :href="route('logistik.manual-input')"
                    :current="request()->routeIs('logistik.manual-input')" wire:navigate>
                    {{ __('Manual Input') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
        @endif

        {{-- Menu Akuntansi --}}
        @if (auth()->user()?->role === 'akuntansi')
            <flux:sidebar.group :heading="__('Input Data')" class="grid">
                <flux:sidebar.item icon="cloud-arrow-up" :href="route('akuntansi.upload-sap')"
                    :current="request()->routeIs('akuntansi.upload-sap')" wire:navigate>
                    {{ __('Upload SAP') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="pencil-square" :href="route('akuntansi.manual-input')"
                    :current="request()->routeIs('akuntansi.manual-input')" wire:navigate>
                    {{ __('Manual Input') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group :heading="__('Manajemen Project')" class="grid">
                <flux:sidebar.item icon="clipboard-document-list" :href="route('akuntansi.my-take-list')"
                    :current="request()->routeIs('akuntansi.my-take-list')" wire:navigate>
                    {{ __('My Take List') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="chart-bar" :href="route('akuntansi.project-execution')"
                    :current="request()->routeIs('akuntansi.project-execution')" wire:navigate>
                    {{ __('Project Execution') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group :heading="__('Laporan')" class="grid">
                <flux:sidebar.item icon="arrow-down-tray" :href="route('akuntansi.project-execution-export')"
                    :current="request()->routeIs('akuntansi.project-execution-export')" wire:navigate>
                    {{ __('Export Project') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
        @endif

        {{-- Menu Konstruksi --}}
        @if (auth()->user()?->role === 'konstruksi')
            <flux:sidebar.group :heading="__('Manajemen Project')" class="grid">
                <flux:sidebar.item icon="clipboard-document-list" :href="route('konstruksi.my-take-list')"
                    :current="request()->routeIs('konstruksi.my-take-list')" wire:navigate>
                    {{ __('My Take List') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="wrench-screwdriver" :href="route('konstruksi.real-work')"
                    :current="request()->routeIs('konstruksi.real-work')" wire:navigate>
                    {{ __('Real Work') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
        @endif

        {{-- Menu Admin --}}
        @if (auth()->user()?->role === 'admin')
            <flux:sidebar.group :heading="__('Administrasi')" class="grid">
                <flux:sidebar.item icon="user-plus" :href="route('register')"
                    :current="request()->routeIs('register')" wire:navigate>
                    {{ __('Tambah User') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
        @endif

        {{-- Menu Informasi - Selalu tampil untuk semua role --}}
        <flux:sidebar.group :heading="__('Informasi')" class="grid">
            <flux:sidebar.item icon="information-circle" :href="route('tabel-info')"
                :current="request()->routeIs('tabel-info')" wire:navigate>
                {{ __('Tabel Info') }}
            </flux:sidebar.item>
        </flux:sidebar.group>
    </flux:sidebar.nav>

    <flux:spacer />

    <flux:sidebar.nav>
        {{-- <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
            target="_blank">
            {{ __('Repository') }}
        </flux:sidebar.item>

        <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
            target="_blank">
            {{ __('Documentation') }}
        </flux:sidebar.item> --}}
    </flux:sidebar.nav>

    <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
</flux:sidebar>


<!-- Mobile User Menu -->
<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <flux:spacer />

    <flux:dropdown position="top" align="end">
        <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                            <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                    {{ __('Settings') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer" data-test="logout-button">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

{{ $slot }}
