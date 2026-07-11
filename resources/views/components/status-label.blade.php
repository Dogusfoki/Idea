@props(['status' => 'pending'])

@php

    use App\Enums\IdeaStatus;

    $colors = [
        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200',
        'completed' => 'bg-green-100 text-green-800 border-green-200',
    ];

    $labels = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
    ];

    $statusValue = $status instanceof IdeaStatus ? $status->value : $status;
    $colorClass = $colors[$statusValue] ?? $colors['pending'];
    $label = $labels[$statusValue] ?? 'Pending';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {$colorClass}"]) }}>
    {{ $label }}
</span>
