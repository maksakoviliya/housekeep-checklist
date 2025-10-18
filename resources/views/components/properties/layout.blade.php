<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item href="{{ route('properties.edit', [
                    'property' => $property->id,
                ]) }}" :current="request()->routeIs('properties.edit')"
                               wire:navigate>{{ __('Info') }}</flux:navlist.item>
            <flux:navlist.item href="{{route('properties.rooms.index', [
                    'property' => $property->id,
                ])}}" :current="request()->is('properties/*/rooms/*') || request()->is('properties/*/rooms')"
                               wire:navigate>{{ __('Rooms') }}</flux:navlist.item>
            {{--            <flux:navlist.item :href="route('settings.appearance')" :current="request()->routeIs('settings.appearance')"--}}
            {{--                               wire:navigate>{{ __('Appearance') }}</flux:navlist.item>--}}
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden"/>

    <div class="flex-1 self-stretch max-md:pt-6">
        <div class="mt-5 w-full max-w-2xl">
            <div class="flex items-center gap-4 justify-between w-full">
                <div>
                    <flux:heading>{{ $heading ?? '' }}</flux:heading>
                    <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>
                </div>

                {{ $headingAction ?? '' }}
            </div>
            
            {{ $slot }}
        </div>
    </div>
</div>
