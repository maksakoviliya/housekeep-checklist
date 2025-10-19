<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex items-center justify-between gap-4">
        <div class="sm:flex-auto">
            <flux:heading level="3">{{ __('Default rooms') }}</flux:heading>
            <flux:text class="hidden sm:inline">{{ __('Manage default rooms for every property') }}</flux:text>
        </div>

        <flux:modal.trigger name="create-default-room">
            <flux:button icon="plus">{{ __('Create default room') }}</flux:button>
        </flux:modal.trigger>

        <flux:modal name="create-default-room" focusable class="w-full max-w-lg">
            <form wire:submit="createRoom" class="space-y-6">
                <flux:heading size="lg">{{ __('Create default room') }}</flux:heading>

                <flux:input
                        wire:model="name"
                        :label="__('Name')"
                        type="string"
                        autofocus
                />

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="primary" type="submit">{{ __('Create') }}</flux:button>
                </div>
            </form>
        </flux:modal>
    </div>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block w-full max-w-2xl py-2 align-middle sm:px-6 lg:px-8">
                <x-table.table>
                    <x-slot:head>
                        <x-table.heading>{{ __('Name') }}</x-table.heading>
                        <x-table.heading>{{ __('Created at') }}</x-table.heading>
                        <x-table.heading></x-table.heading>
                    </x-slot:head>
                    <x-slot:body>
                        @foreach($this->defaultRooms as $room)
                            <x-table.row>
                                <x-table.cell>{{ $room->name }}</x-table.cell>
                                <x-table.cell>{{ $room->created_at->format('d.m.Y H:i') }}</x-table.cell>
                                <x-table.cell class="text-right">
                                    <flux:modal.trigger name="confirm-default-room-deleting">
                                        <flux:tooltip content="{{ __('Delete') }}">
                                            <flux:button size="sm" variant="danger" icon="trash" wire:click="setActiveRoom({{ $room }})"></flux:button>
                                        </flux:tooltip>
                                    </flux:modal.trigger>
                                </x-table.cell>
                            </x-table.row>
                        @endforeach
                    </x-slot:body>
                    <x-slot:empty>
                        {{__('No default found.')}}
                    </x-slot:empty>
                </x-table.table>
            </div>
        </div>
    </div>

    <flux:modal name="confirm-default-room-deleting" class="max-w-lg">
        <form wire:submit="deleteRoom" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Are you sure you want to delete default room?') }}</flux:heading>

                <flux:subheading>
                    {{ __('Once your property is deleted, all of its data will be permanently deleted.') }}
                </flux:subheading>
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('Delete default room') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>