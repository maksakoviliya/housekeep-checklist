<div class="flex items-start gap-4 justify-between">
    <flux:text>{{ $task->task }}</flux:text>

    <flux:modal.trigger name="confirm-task-deletion">
        <flux:button size="sm" icon="trash" wire:click="confirmDeleting" class="flex-shrink-0"/>
    </flux:modal.trigger>
</div>
