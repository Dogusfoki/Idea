@props(['label', 'name', 'type' => 'text', 'required' => false, 'placeholder' => '', 'value' => null])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>

    @if($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'w-full border rounded p-2']) }}
            @if($required) required @endif
        >{{ old($name, $value) }}</textarea>
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge(['class' => 'w-full border rounded p-2']) }}
            @if($required) required @endif
        />
    @endif

    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
