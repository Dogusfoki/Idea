@props(['class' => ''])

<div {{ $attributes->merge(['class' => "bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition {$class}"]) }}>
    {{ $slot }}
    <x-status-label :status="$idea->status" />

</div>
