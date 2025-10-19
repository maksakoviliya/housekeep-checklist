<x-layouts.app :title="__('Properties')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between gap-4">
            <div class="sm:flex-auto">
                <flux:heading level="3">{{ __('Properties') }}</flux:heading>
                <flux:text class="hidden sm:inline">{{ __('This information about properties.') }}</flux:text>
            </div>
        </div>
        <div class="mt-8 flow-root">
           <livewire:schedule.housekeeper-calendar />
        </div>
    </div>
</x-layouts.app>
