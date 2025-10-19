<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative p-8 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <dt>
                    <flux:text class="truncate">
                        {{ __('Total users') }}
                    </flux:text>
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    <flux:heading size="xl" class="truncate">
                        {{ \App\Models\User::query()->count() }}
                    </flux:heading>
                </dd>
            </div>
            <div class="relative p-8 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <dt>
                    <flux:text class="truncate">
                        {{ __('Total rooms') }}
                    </flux:text>
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    <flux:heading size="xl" class="truncate">
                        {{ \App\Models\Room::query()->count() }}
                    </flux:heading>
                </dd>
            </div>
            <div class="relative p-8 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <dt>
                    <flux:text class="truncate">
                        {{ __('Total tasks') }}
                    </flux:text>
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                    <flux:heading size="xl" class="truncate">
                        {{ \App\Models\Task::query()->count() }}
                    </flux:heading>
                </dd>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
