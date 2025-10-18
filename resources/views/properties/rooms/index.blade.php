<x-layouts.app :title="__('Dashboard')">
    <section class="w-full">
        @include('partials.property-heading')

        <x-properties.layout heading="{{ $property->name }}" :subheading="__('View rooms')"
                             :property="$property">
            <x-slot:headingAction>
                <flux:button href="{{ route('properties.rooms.create', [
                    'property' => $property->id,
                ]) }}" wire:navigate icon="plus">{{ __('Create room') }}</flux:button>
            </x-slot:headingAction>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <x-table.table>
                            <x-slot:head>
                                <x-table.heading>{{ __('Name') }}</x-table.heading>
                                <x-table.heading>{{ __('Created') }}</x-table.heading>
                                <x-table.heading></x-table.heading>
                            </x-slot:head>
                            <x-slot:body>
                                @foreach($rooms as $room)
                                    <x-table.row>
                                        <x-table.cell>{{ $room->name }}</x-table.cell>
                                        <x-table.cell>{{ $property->created_at->format('d.m.Y H:i') }}</x-table.cell>
                                        <x-table.cell class="text-right">
                                            <flux:tooltip content="{{ __('Edit') }}">
                                                <flux:button href="{{ route('properties.rooms.edit', [
                                                'property' => $property->id,
                                                'room' => $room->id,
                                            ]) }}" size="sm" wire:navigate icon="pencil"></flux:button>
                                            </flux:tooltip>
                                        </x-table.cell>
                                    </x-table.row>
                                @endforeach
                            </x-slot:body>
                            <x-slot:empty>
                                {{__('No rooms found.')}}
                            </x-slot:empty>
                        </x-table.table>

                        {!! $rooms->links() !!}
                    </div>
                </div>
            </div>
        </x-properties.layout>
    </section>
</x-layouts.app>
