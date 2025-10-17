@props([
    'head',
    'body',
    'empty' => null,
])

<table class="relative min-w-full divide-y divide-zinc-800/10 dark:divide-white/20">
    <thead {{ $head->attributes }}>
    <tr>
        {{ $head }}
    </tr>
    </thead>
    <tbody {{ $body->attributes->merge(['class' => 'divide-y divide-gray-200 dark:divide-gray-700']) }}>
    @if ($body->isEmpty())
        <tr>
            <td colspan="100"
                class="text-center p-3 text-sm font-medium text-zinc-800 dark:text-white/60">
                {{ $empty }}
            </td>
        </tr>
    @else
        {{ $body }}
    @endif
    </tbody>
</table>