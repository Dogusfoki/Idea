@props(['title', 'description' => null])

<div class="max-w-md mx-auto mt-2">
    <div>
        @if($title)
        <h1>{{ $title }}</h1>
        @endif
        @if($description)
        <p> {{ $description }} </p>
        @endif
        <form {{ $attributes->merge(['class' => 'space-y-4']) }}>
            {{ $slot }}
        </form>
    </div>

</div>
