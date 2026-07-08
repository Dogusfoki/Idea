@props (['type' => 'succes'])

if(session()->has('succes')) || session()->has()'error' || session()->has('warning'))

@php
$type = session()->has('success') ? 'success' : (session()->has('error')
? 'error' : 'warning');
    $message = session($type);

    $colors = [
        'success' => 'bg-green-500',
        'error' => 'bg-red-500',
        'warning' => 'bg-yellow',
    ];
    @endphp
    <div x-data="{ show:true }">
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:enter="transirion ease-out duration-300"
        x-transition:enter-star="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100"transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" transform translate-y-0"
        x-transition:leave-end="opacity-0" transform translate-y-2
        class="fixed bottom-4 right-4 z-50 max-w-sm w-full">
        <div class="{{ $colors($type) }} text-white px-6 py-4 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <span>{{ $message }}</span>
                <button @click>x</button>

            </div>
        </div>
    </div>
