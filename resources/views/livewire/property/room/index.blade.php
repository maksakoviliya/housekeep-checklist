<div x-init="
                window.addEventListener('new-room-created', e => {
                    $flux.modal('create-property-form').close()
                })
            ">
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
                            <x-table.cell>{{ $room->created_at->format('d.m.Y H:i') }}</x-table.cell>
                            <x-table.cell class="text-right flex justify-end gap-2">
                                <livewire:property.room.form.edit :key="$room->id" :room="$room"/>
                                <livewire:property.room.form.delete :key="$room->id" :room="$room"/>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-slot:body>
                <x-slot:empty>
                    {{__('No rooms found.')}}
                </x-slot:empty>
            </x-table.table>
        </div>
    </div>
    <div class="flex items-center mt-4 gap-4">
        <flux:modal.trigger name="create-property-form">
            <flux:button variant="primary"  icon="plus">{{ __('Create room') }}</flux:button>
        </flux:modal.trigger>
        <flux:button wire:click="attachDefaultRooms">{{ __('Attach default rooms') }}</flux:button>
    </div>
    
    <flux:modal name="create-property-form" focusable class="max-w-lg">
        <livewire:property.room.form.create :property="$property"/>
    </flux:modal>

    <flux:modal name="confirm-task-deletion" class="max-w-lg">
        <livewire:task.form.delete/>
    </flux:modal>
</div>
