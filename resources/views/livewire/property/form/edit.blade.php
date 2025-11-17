<section class="w-full">
    @include('partials.property-heading')

    <x-properties.layout heading="{{ $property->name }}" :subheading="__('Update your property')" :property="$property">
        <form wire:submit="submit" class="my-6 w-full space-y-6">
            @if ($photo)
                <img src="{{ is_string($photo) ? \Illuminate\Support\Facades\Storage::disk('public')->url($photo) : $photo->temporaryUrl() }}"
                     class="w-92 aspect-3/2 object-cover rounded-xl" alt="">
            @endif
            <flux:input type="file" wire:model="photo" label="photo"/>

            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"/>

            @can('assignProperty', \App\Models\Property::class)
                <flux:select wire:model="userId" :label="__('Owner')" required>
                    <option value="">{{ __('Select owner') }}</option>
                    @foreach($users ?? [] as $user)
                        <option value="{{ $user->id }}">{{ '@' . $user->login }} - {{ $user->name }}</option>
                    @endforeach
                </flux:select>
            @endcan

            <flux:textarea wire:model.live.debounce.1500ms="address" 
                           :label="__('Address')"
                           type="text"
                           required 
                           autofocus
                           autocomplete="address"/>

            <div class="grid grid-cols-2 gap-4 relative">
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-white/20 rounded-lg overflow-hidden hidden" wire:loading.class.remove="hidden">
                    <flux:icon.loading />
                </div>
                <flux:input wire:model="lat" wire:loading.attr="disabled" :label="__('Lattitude')" type="text" required autofocus
                            autocomplete="lat"/>
                <flux:input wire:model="lng" wire:loading.attr="disabled" :label="__('Longitude')" type="text" required autofocus
                            autocomplete="lng"/>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>
                <x-action-message class="me-3" on="property-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <flux:separator/>

        <livewire:property.form.delete :property="$property"/>
    </x-properties.layout>
</section>
