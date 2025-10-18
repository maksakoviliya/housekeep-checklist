<x-layouts.app :title="__('Properties')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between gap-4">
            <div class="sm:flex-auto">
                <flux:heading level="3">{{ __('Properties') }}</flux:heading>
                <flux:text class="hidden sm:inline">{{ __('This information about properties.') }}</flux:text>
            </div>
            @can('create', App\Models\Property::class)
                <flux:button icon="plus" href="{{ route('properties.create') }}">{{ __('Create property') }}</flux:button>
            @endcan
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <x-table.table>
                        <x-slot:head>
                            <x-table.heading>{{ __('Name') }}</x-table.heading>
                            <x-table.heading>{{ __('Beds') }}</x-table.heading>
                            <x-table.heading>{{ __('Baths') }}</x-table.heading>
                            <x-table.heading>{{ __('Created') }}</x-table.heading>
                            <x-table.heading></x-table.heading>
                        </x-slot:head>
                        <x-slot:body>
                            @foreach($properties as $property)
                                <x-table.row>
                                    <x-table.cell>{{ $property->name }}</x-table.cell>
                                    <x-table.cell>{{ $property->beds }}</x-table.cell>
                                    <x-table.cell>{{ $property->baths }}</x-table.cell>
                                    <x-table.cell>{{ $property->created_at->format('d.m.Y H:i') }}</x-table.cell>
                                    <x-table.cell class="text-right">
                                        <flux:tooltip content="{{ __('Edit') }}">
                                            <flux:button href="{{ route('properties.edit', [
                                                'property' => $property->id,
                                            ]) }}" size="sm" icon="pencil"></flux:button>
                                        </flux:tooltip>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        </x-slot:body>
                        <x-slot:empty>
                            {{__('No properties found.')}}
                        </x-slot:empty>
                    </x-table.table>

                    {!! $properties->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
