<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl"
     x-data="{ error: null, timeout: null }"
     x-init="
            window.addEventListener('geolocation-error', e => { 
                clearTimeout(timeout);
                error = e.detail?.error || '{{ __('Something went wrong. Try again or contact support.') }}'; 
                timeout = setTimeout(() => error = null, 4000);
            })
            window.addEventListener('geolocation-success', e => { 
                console.log('success', e.detail);
                $wire.startCleaning(e.detail);
            })
        " xmlns:flux="http://www.w3.org/1999/html">
    <div class="flex items-center justify-between gap-4">
        <div class="sm:flex-auto">
            <flux:heading level="3">{{ $schedule->property->name }}</flux:heading>
            <flux:text class="hidden sm:inline">
                {{ __('Need to clean at :at', [
                    'at' => $schedule->scheduled_at->format('d.m.Y H:i')
                ]) }}
            </flux:text>
        </div>
    </div>

    <div class="mt-8 flow-root">
        @foreach($schedule->property->rooms as $room)
            <div class="space-y-6">
                <flux:separator/>

                <flux:heading>{{ $room->name }} tasks:</flux:heading>

                <div class="space-y-2">

                    @foreach($room->tasks as $task)
                        <div class="flex items-start gap-4 justify-start w-full">
                            <flux:icon.check variant="mini" class="size-4"/>
                            <flux:text>{{ $task->task }}</flux:text>

                            @if($schedule->status === \App\Enums\ScheduleStatus::IN_PROGRESS)
                                @if(!$task->checklist)
                                    <flux:modal.trigger name="create-checklist">
                                        <flux:button size="xs" class="ml-auto" icon="check"
                                                     wire:click="setActiveTask({{ $task }})">
                                            {{ __('Check') }}
                                        </flux:button>
                                    </flux:modal-trigger>
                                @else
                                    <flux:modal.trigger name="view-checklist">
                                        <flux:button size="xs" class="ml-auto" icon="check" variant="primary"
                                                     color="green" wire:click="setActiveTask({{ $task }})">
                                            {{ __('Done') }}
                                        </flux:button>
                                    </flux:modal.trigger>
                                @endif
                            @endif
                        </div>
                    @endforeach

                </div>
                <flux:separator/>
            </div>
        @endforeach

        <flux:modal name="create-checklist" focusable class="w-full max-w-lg">
            <form method="POST" wire:submit="createChecklist" class="space-y-6" enctype="multipart/form-data">
                <div>
                    <flux:heading size="lg">{{ __('Set task completed') }}</flux:heading>

                    <flux:subheading>
                        {{ __('Confirm that all data is ') }}
                    </flux:subheading>
                </div>

                <flux:input type="file" wire:model="images" label="Photos" multiple/>

                @if(!empty($images))
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($images as $image)
                            <div class="w-full h-48 overflow-hidden rounded-md">
                                <img src="{{ $image->temporaryUrl() }}" class="object-cover h-full w-full"/>
                            </div>
                        @endforeach
                    </div>
                @endif

                <flux:textarea wire:model="notes" resize="none" label="{{ __('Notes') }}"
                               placeholder="{{ __('Add any relevant notes about the task...') }}"/>

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="primary" color="green" type="submit" :disabled="empty($images)">
                        {{ __('Mark as done') }}
                    </flux:button>
                </div>
            </form>
        </flux:modal>


        @if($schedule->status === \App\Enums\ScheduleStatus::PENDING)
            <div class="flex justify-end">
                <flux:button id="start-to-clean" class="mt-6 w-full max-w-sm" variant="primary">
                    {{ __('Start clean') }}
                </flux:button>
            </div>
            <template x-if="error">
                <flux:callout
                        variant="danger"
                        icon="exclamation-circle"
                        class="mt-6"
                >
                    <span x-text="error"></span>
                </flux:callout>
            </template>
        @endif
    </div>
</div>