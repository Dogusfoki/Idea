@props(['label', 'name', 'type' => 'text', 'required' => false])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name) }}" @if($required) required @endif>
    @error($name)
    <p>{{ $message }}</p>
    @enderror

</div>
