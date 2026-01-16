{{-- custom layout for admin --}}
<x-layouts.app.sidebar :title="'Register User'">

    <div class="mx-auto flex max-w-md flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}"
            class="flex flex-col gap-6 rounded-xl bg-white p-6 shadow-lg dark:bg-[#2d2d3d]">
            @csrf

            <flux:input name="name" label="Name" type="text" required autofocus autocomplete="name"
                placeholder="Full name" />

            <flux:input name="email" label="Email address" type="email" required autocomplete="email"
                placeholder="email@example.com" />

            <flux:input name="password" label="Password" type="password" required autocomplete="new-password"
                viewable />

            <flux:input name="password_confirmation" label="Confirm password" type="password" required
                autocomplete="new-password" viewable />
            <flux:select name="role" label="Role" wire:model="role" required>
                <option value="logistik">Logistik</option>
                <option value="konstruksi">Konstruksi</option>
                <option value="akuntansi">Akuntansi</option>
            </flux:select>

            <flux:button type="submit" variant="primary"
                class="!bg-primary-500 hover:!bg-primary-600 w-full !text-white">
                Create account
            </flux:button>
        </form>



        <div class="space-x-1 text-center text-sm text-zinc-600 rtl:space-x-reverse dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" class="text-primary-500 hover:text-primary-600 dark:text-primary-400"
                wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts.app.sidebar>
