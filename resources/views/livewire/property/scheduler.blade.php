<div class="col-span-2 mt-10">
    <div>
        <livewire:schedule.calendar :property="$property"/>
    </div>

    <flux:modal name="schedule-cleaning" class="w-full max-w-lg" x-data x-init="
                window.addEventListener('calendar-date-clicked', e => {
                    $flux.modal('schedule-cleaning').show()
                })
            ">
        <livewire:schedule.form.create :property="$property"/>
    </flux:modal>

    <flux:modal name="schedule-edit" variant="flyout" class="w-full max-w-lg" x-data x-init="
                window.addEventListener('calendar-event-clicked', e => {
                    $flux.modal('schedule-edit').show()
                })
            ">
        <livewire:schedule.form.edit :property="$property"/>
    </flux:modal>
</div>
