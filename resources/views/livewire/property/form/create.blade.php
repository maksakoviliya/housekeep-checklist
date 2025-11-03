<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl max-w-lg"
     x-data="{  error: null,
                lat: $wire.entangle('lat').live,
                lng: $wire.entangle('lng').live
      }"
     x-init="
            window.addEventListener('geolocation-error', e => { 
                error = '{{ __('Denied Geolocation.') }}'; 
            })
             window.addEventListener('geolocation-success', (e) => {
                console.log('geolocation-success', e)
                let {lat, lng} = e.detail;
                $wire.set('lat', lat);
                $wire.set('lng', lng);
            });
        
            window.addEventListener('geolocation-fallback', (e) => {
                console.log('geolocation-fallback', e)
                let {latitude, longitude} = e.detail;
                $wire.set('lat', latitude);
                $wire.set('lng', longitude);
            });
        " xmlns:flux="http://www.w3.org/1999/html">
    <div class="flex items-center justify-between gap-4">
        <div class="sm:flex-auto">
            <flux:heading level="3">{{ __('Create property') }}</flux:heading>
            <flux:text class="hidden sm:inline">{{ __('Create new property') }}</flux:text>
        </div>
    </div>

    <form wire:submit="createProperty" class="my-6 w-full space-y-6">
{{--        @if ($photo)--}}
{{--            <img src="{{ $photo->temporaryUrl() }}" class="w-92 aspect-3/2 object-cover rounded-xl" alt="">--}}
{{--        @endif--}}
        <flux:input type="file" wire:model="photo" :label="__('Photo')"/>
            
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"/>

        @can('assignProperty', \App\Models\Property::class)
            <flux:select wire:model="userId" :label="__('Owner')" required>
                <option value="">{{ __('Select owner') }}</option>
                @foreach($users ?? [] as $user)
                    <option value="{{ $user->id }}">{{ '@' . $user->login }} - {{ $user->name }}</option>
                @endforeach
            </flux:select>
        @endcan

        <flux:textarea wire:model="address" :label="__('Address')" type="text" required autofocus
                       autocomplete="address"/>

        <div class="grid grid-cols-2 gap-4">
            <flux:input wire:model="lat" :label="__('Lattitude')" type="text" required autofocus autocomplete="lat"/>
            <flux:input wire:model="lng" :label="__('Longitude')" type="text" required autofocus autocomplete="lng"/>
        </div>

        <template x-if="error">
            <flux:callout
                    variant="danger"
                    icon="exclamation-circle"
                    class="mt-6"
            >
                <span x-text="error"></span>
            </flux:callout>
        </template>

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
            </div>
        </div>
    </form>
</div>

