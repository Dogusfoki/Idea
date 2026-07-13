@props(['name', 'title'])

<div
    x-data="{ show: false }"
    @open-modal.window="if ($event.detail.name === '{{ $name }}') show = true"
    @keydown.escape.window="show = false"
    x-show="show"
    style="display: none;"
    x-cloak
    role="dialog"
    aria-modal="true"
    :aria-hidden="!show"
    aria-labelledby="modal-{{ $name }}-title"
    class="modal modal-open"
>
    <div class="modal-box" @click.away="show = false">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modal-{{ $name }}-title" class="text-lg font-bold">{{ $title }}</h2>
            <button @click="show = false" class="btn btn-sm btn-circle btn-ghost">✕</button>
        </div>
        <div>
            <x-create-idea-modal />
        </div>
    </div>
</div>
