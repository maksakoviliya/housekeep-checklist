<form method="POST" wire:submit="submitDeleting" class="space-y-6">
    <div>
        <flux:heading size="lg">{{ __('Are you sure you want to delete task?') }}</flux:heading>

        <flux:subheading>
            {{ __('All task data will be permanently deleted.') }}
        </flux:subheading>
    </div>
    <div class="flex justify-end space-x-2 rtl:space-x-reverse mt-4">
        <flux:modal.close>
            <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
        </flux:modal.close>

        <flux:button variant="danger" type="submit">{{ __('Delete task') }}</flux:button>
    </div>
</form>