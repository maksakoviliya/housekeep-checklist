<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 items-start max-md:flex-col">
    <div class="mt-5 w-full">
        <div class="flex items-center gap-4 justify-between w-full">
            <div>
                <flux:heading>{{ $heading ?? '' }}</flux:heading>
                <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>
            </div>

            {{ $headingAction ?? '' }}
        </div>

        {{ $slot }}
    </div>
</div>
