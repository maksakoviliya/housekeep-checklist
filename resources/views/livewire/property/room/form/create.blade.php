<section class="w-full">
    @include('partials.property-heading')

    <x-properties.layout heading="{{ $property->name }}" :subheading="__('Crete room')"
                         :property="$property">
        <div class="mt-8 flow-root">
            <form wire:submit="submit" class="my-6 w-full space-y-6">
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"/>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
                    </div>
                </div>
            </form>
        </div>
    </x-properties.layout>
</section>