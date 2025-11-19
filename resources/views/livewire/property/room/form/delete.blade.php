<div>
    <flux:modal.trigger name="{{ 'confirm-room-deletion_' . $room->id }}">
        <flux:tooltip content="{{ __('Delete') }}">
            <flux:button size="sm" variant="danger" icon="trash"></flux:button>
        </flux:tooltip>
    </flux:modal.trigger>

    <flux:modal name="{{ 'confirm-room-deletion_' . $room->id }}" class="max-w-lg">
        <form class="space-y-6 text-left">
            <div>
                <flux:heading size="lg">{{ __('Are you sure you want to delete your room?') }}</flux:heading>

                <flux:subheading>
                    {{ __('Once your room is deleted, all of its resources and data will be permanently deleted.') }}
                </flux:subheading>
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="button" wire:click="deleteRoomConfirmation">
                    {{ __('Delete room') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
