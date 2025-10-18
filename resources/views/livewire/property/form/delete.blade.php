<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Delete property') }}</flux:heading>
        <flux:subheading>{{ __('Delete your property and all of its data') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-property-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-property-deletion')">
            {{ __('Delete property') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-property-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form method="POST" wire:submit="deleteProperty" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Are you sure you want to delete your property?') }}</flux:heading>

                <flux:subheading>
                    {{ __('Once your property is deleted, all of its resources and data will be permanently deleted.') }}
                </flux:subheading>
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('Delete property') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
