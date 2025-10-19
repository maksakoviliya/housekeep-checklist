<x-layouts.app :title="__('Properties')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between gap-4">
            <div class="sm:flex-auto">
                <flux:heading level="3">{{ __('Users') }}</flux:heading>
                <flux:text class="hidden sm:inline">{{ __('This information about users.') }}</flux:text>
            </div>

            <flux:button icon="plus" href="{{ route('dashboard.users.create') }}"
                         wire:navigate>{{ __('Create user') }}</flux:button>
            
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <x-table.table>
                        <x-slot:head>
                            <x-table.heading>{{ __('Name') }}</x-table.heading>
                            <x-table.heading>{{ __('Email') }}</x-table.heading>
                            <x-table.heading>{{ __('Role') }}</x-table.heading>
                            <x-table.heading>{{ __('Created') }}</x-table.heading>
                            <x-table.heading></x-table.heading>
                        </x-slot:head>
                        <x-slot:body>
                            @foreach($users as $user)
                                <x-table.row>
                                    <x-table.cell>{{ $user->name }}</x-table.cell>
                                    <x-table.cell>{{ $user->email }}</x-table.cell>
                                    <x-table.cell>
                                        <flux:badge size="sm">{{ $user->role->label() }}</flux:badge>
                                    </x-table.cell>
                                    <x-table.cell>{{ $user->created_at->format('d.m.Y H:i') }}</x-table.cell>
                                    <x-table.cell class="text-right">
                                        <flux:tooltip content="{{ __('Edit') }}">
                                            <flux:button href="{{ route('dashboard.users.edit', [
                                                'user' => $user->id,
                                            ]) }}" wire:navigate size="sm" icon="pencil"></flux:button>
                                        </flux:tooltip>
                                    </x-table.cell>
                                </x-table.row>
                            @endforeach
                        </x-slot:body>
                        <x-slot:empty>
                            {{__('No properties found.')}}
                        </x-slot:empty>
                    </x-table.table>

                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
