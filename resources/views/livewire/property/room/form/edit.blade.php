<section class="w-full">
    @include('partials.property-heading')

    <x-properties.layout heading="{{ $property->name }}" :subheading="__('Edit room')"
                         :property="$property">
        <div class="mt-8 flow-root">
            <form wire:submit="submit" class="my-6 w-full space-y-6">
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"/>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>
                    <x-action-message class="me-3" on="room-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>
        </div>
    </x-properties.layout>
</section>