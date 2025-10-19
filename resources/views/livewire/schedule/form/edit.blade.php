<div class="space-y-6">
    <form wire:submit="submit" class="space-y-6">
        <div>
            <flux:heading size="lg">{{__('Update schedule')}}</flux:heading>
            <flux:text class="mt-2">
                {{ __('Make changes to schedule details.') }}
            </flux:text>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:input type="date" wire:model="date" label="{{ __('Date') }}"/>
            <flux:select wire:model="time" label="{{ __('Time') }}">
                @foreach($timeAvailable as $time)
                    <flux:select.option value="{{ $time }}" wire:key="$time">{{ $time }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <flux:select label="{{ __('Housekeeper') }}" wire:model="housekeeperId">
            <flux:select.option value="">{{ __('Select housekeeper') }}</flux:select.option>
            @foreach($this->housekeepers as $housekeeper)
                <flux:select.option :value="$housekeeper->id">
                    {{ $housekeeper->name }}
                </flux:select.option>
            @endforeach
        </flux:select>

        <div class="flex">
            <flux:spacer/>

            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
        </div>
    </form>

    <flux:separator/>

    <livewire:schedule.form.delete :schedule="$schedule" />
</div>

<script>
    window.addEventListener('calendar-event-clicked', event => {
    @this.call('setEvent', event.detail)
    })
</script>