<div>
    <flux:modal.trigger name="{{ 'confirm-room-edit_' . $room->id }}">
        <flux:tooltip content="{{ __('Edit') }}">
            <flux:button size="sm" icon="pencil"></flux:button>
        </flux:tooltip>
    </flux:modal.trigger>

    <flux:modal name="{{ 'confirm-room-edit_' . $room->id }}" class="max-w-xl w-full">
        <form wire:submit="submit" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"/>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>
                <x-action-message class="me-3" on="room-updated">
                    {{ __('Saved.') }}
                </x-action-message>
                <x-action-message class="me-3" on="task-deleted">
                    {{ __('Task has been deleted.') }}
                </x-action-message>
            </div>

            <flux:separator/>

            <div class="flex justify-between items-center">
                <flux:heading>{{ __('Manage tasks') }}</flux:heading>

                <flux:modal.trigger name="add-task">
                    <flux:button size="sm" variant="primary" icon="plus">New task</flux:button>
                </flux:modal.trigger>
            </div>

            <div class="space-y-2 max-h-80 overflow-y-auto">
                @forelse($tasks as $task)
                    <livewire:task.item :task="$task" wire:key="task-{{ $task->id }}"/>
                @empty
                    <div class="text-center p-3 text-sm font-medium text-zinc-800/60 dark:text-white/60">
                        {{ __('There are no tasks yet') }}
                    </div>
                @endforelse
            </div>
        </form>
    </flux:modal>

    <flux:modal name="add-task" class="md:w-96">
        <livewire:task.form.create :room="$room" :property="$property"/>
    </flux:modal>

    <flux:modal name="confirm-task-deletion" class="max-w-lg">
        <livewire:task.form.delete/>
    </flux:modal>

</div>