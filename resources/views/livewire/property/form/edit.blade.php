<section class="w-full">
    @include('partials.property-heading')

    <x-properties.layout heading="{{ $property->name }}" :subheading="__('Update your property')" :property="$property">
        <form wire:submit="submit" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"/>
            <flux:input wire:model="beds" :label="__('Beds')" type="number" required autocomplete="beds"/>
            <flux:input wire:model="baths" :label="__('Baths')" type="number" required autocomplete="baths"/>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>
                <x-action-message class="me-3" on="property-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:property.form.delete :property="$property" />
    </x-properties.layout>
</section>
