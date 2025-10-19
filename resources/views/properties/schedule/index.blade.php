<x-layouts.app :title="__('Dashboard')">
    <section class="w-full">
        @include('partials.property-heading')

        <x-properties.layout heading="{{ $property->name }}" :subheading="__('Schedule')"
                             :property="$property">
            <x-slot:headingAction>
                <flux:modal.trigger name="schedule-cleaning">
                    <flux:button icon="plus">{{ __('Schedule cleaning') }}</flux:button>
                </flux:modal.trigger>
            </x-slot:headingAction>

            <div class="mt-8">
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


        </x-properties.layout>
    </section>
</x-layouts.app>
