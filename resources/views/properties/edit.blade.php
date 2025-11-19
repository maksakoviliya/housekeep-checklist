<x-layouts.app :title="__('Properties')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex items-center justify-between gap-4">
            @include('partials.property-heading')
        </div>
        <div class="mt-8 flex flex-col gap-4 w-full max-w-4xl mx-auto">
            <livewire:property.form.edit :property="$property"/>
            
            <flux:separator/>
            <livewire:property.room.index :property="$property"/>
            
            <flux:separator/>
            <livewire:property.scheduler :property="$property"/>

            <flux:separator/>
            <livewire:property.form.delete :property="$property"/>
        </div>
    </div>
</x-layouts.app>
