<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex items-center justify-between gap-4">
        <div class="sm:flex-auto">
            <flux:heading level="3">{{ __('Create property') }}</flux:heading>
            <flux:text class="hidden sm:inline">{{ __('Create new property') }}</flux:text>
        </div>
    </div>

    <form wire:submit="submit" class="my-6 w-full space-y-6">
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"/>
        <flux:input wire:model="beds" :label="__('Beds')" type="number" required autocomplete="beds"/>
        <flux:input wire:model="baths" :label="__('Baths')" type="number" required autocomplete="baths"/>

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
            </div>
        </div>
    </form>
</div>