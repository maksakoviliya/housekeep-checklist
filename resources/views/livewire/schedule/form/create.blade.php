<form wire:submit="submit" class="space-y-6">
    <div class="space-y-4">
       <div class="">
           <flux:heading size="lg">{{ __('Schedule cleaning') }}</flux:heading>

           <flux:subheading>
               {{ __('Select date and assign housekeeper') }}
           </flux:subheading>
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
    </div>

    <div class="flex justify-end space-x-2 rtl:space-x-reverse">
        <flux:modal.close>
            <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
        </flux:modal.close>

        <flux:button type="submit">{{ __('Save') }}</flux:button>
    </div>
</form>

<script>
    window.addEventListener('calendar-date-clicked', event => {
        @this.call('setDate', event.detail.date)
    })
</script>