<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Delete room') }}</flux:heading>
        <flux:subheading>{{ __('Delete your room and all of its data') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-room-deletion">
        <flux:button variant="danger">
            {{ __('Delete room') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-room-deletion" class="max-w-lg">
        <form class="space-y-6">
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
</section>
