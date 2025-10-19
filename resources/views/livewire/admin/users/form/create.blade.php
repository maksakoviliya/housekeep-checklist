@php use App\Enums\UserRole; @endphp

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex items-center justify-between gap-4">
        <div class="sm:flex-auto">
            <flux:heading level="3">{{ __('Create user') }}</flux:heading>
            <flux:text class="hidden sm:inline">{{ __('Create new user') }}</flux:text>
        </div>
    </div>

    <form wire:submit="createUser" class="my-6 w-full max-w-xl space-y-6">
        <!-- Name -->
        <flux:input
                wire:model="name"
                :label="__('Name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
                wire:model="email"
                :label="__('Email address')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
        />

        <!-- Phone -->
        <flux:input
                wire:model="phone"
                :label="__('Phone')"
                type="string"
                required
                autocomplete="phone"
                placeholder="+1234567890"
        />

        <!-- Role -->
        <flux:radio.group wire:model="role" :label=" __('Role')" variant="segmented">
            <flux:radio label="{{ UserRole::USER->label() }}"
                        value="{{ UserRole::USER->value }}"/>
            <flux:radio label="{{ UserRole::HOUSEKEEPER->label() }}"
                        value="{{ UserRole::HOUSEKEEPER->value }}"/>
            <flux:radio label="{{ UserRole::ADMIN->label() }}"
                        value="{{ UserRole::ADMIN->value }}"/>
        </flux:radio.group>

        <!-- Password -->
        <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
        />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
            </div>
        </div>
    </form>
</div>