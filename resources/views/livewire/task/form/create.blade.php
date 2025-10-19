<form wire:submit="submit" class="space-y-6">
    <div>
        <flux:heading size="lg">{{ __('Create task') }}</flux:heading>
        <flux:text class="mt-2">{{ __('Add details to clean up') }}</flux:text>
    </div>
    <flux:textarea wire:model="task" resize="none" autosize rows="3"
                   wire:keydown.enter="submit"
                   placeholder="{{ __('Sweep floor or clean sink...') }}"
                   class="max-h-[300px]"/>
    <flux:error name="task"/>
    <div class="flex">
        <flux:spacer/>
        <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
    </div>
</form>