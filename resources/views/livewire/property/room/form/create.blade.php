<form wire:submit="submit" class="my-6 w-full space-y-6">
    <flux:input wire:model="name" :label="__('Room name')" type="text" required autofocus autocomplete="name"/>
    <flux:switch wire:model.live="isDefault" label="{{ __('Default') }}" />

    <div class="flex items-center gap-4">
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
        </div>
    </div>
</form>