<x-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">

        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('ideas.index') }}" class="flex items-center gap-2 text-sm font-medium hover:underline">
                <x-icons.arrow-back class="w-4 h-4" />
                Back to Ideas
            </a>

            <div class="flex items-center gap-3">
                <button type="button"
                x-data
                data-test="edit-idea-button"
                @click="$dispatch('open-modal', {name: 'edit-idea'})"
                {{ route('ideas.edit', $idea) }}
                class="btn btn-outline btn-sm">
                  <x-icons.external class="w-4 h-4" />
                    Edit Idea
                </button>

                <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline btn-sm text-red-600 hover:bg-red-50"
                            onclick="return confirm('Are you sure you want to delete this idea?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
            {{-- data --}}

                        @if($idea->image_path)
                <div class="rounded-lg overflow-hidden mb-4">
                    <img src="{{ asset('storage/' . $idea->image_path) }}"
                        alt="{{ $idea->title }}"
                        class="w-full h-auto object-cover">
                </div>
            @endif
        <h1 class="text-3xl font-bold mb-2">{{ $idea->title }}</h1>

        <div class="flex items-center gap-4 mb-6">
            <x-status-label :status="$idea->status" />
            <span class="text-sm text-gray-500">
                Updated {{ $idea->updated_at->diffForHumans() }}
            </span>
        </div>

        <div class="card bg-base-100 shadow-sm mb-6">
            <div class="card-body">
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ $idea->description }}
                </p>
            </div>
        </div>

        @if($idea->links && count($idea->links) > 0)
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-3">Resources & Links</h3>
                <div class="space-y-2">
                    @foreach($idea->links as $link)
                        <a href="{{ $link }}" target="_blank"
                           class="flex items-center gap-2 text-primary hover:underline font-medium">
                            {{ $link }}
                            <x-icons.external class="w-4 h-4" />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Steps -->


        @if($idea->steps && count($idea->steps) > 0)
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-3">Steps</h3>
                <div class="space-y-2">
                    @foreach($idea->steps as $step)
                   <form action="{{ route('steps.update', $step) }}"
                         method="POST"
                         class="flex items-center gap-3">
                         @csrf
                         @method('PATCH')

                        <button type="submit"
                                role="checkbox"
                                aria-checked="{{ $step->completed ? 'true' : 'false' }}"
                                class="size-6 flex items-center justify-center rounded border border-primary {{ $step->completed ? 'bg-green-500' : '' }}">
                            @if ($step->completed)
                                ✓
                            @endif
                        </button>

                        <span class="{{ $step->completed ? 'line-through text-gray-400' : '' }}">
                            {{ $step->description }}
                        </span>
                    </form>
                        <div class="flex items-center gap-3">
                            {{-- <input type="checkbox" {{ $step->completed ? 'checked' : '' }}
                                   class="checkbox checkbox-sm" disabled> --}}
                            {{-- <span class="{{ $step->completed ? 'line-through text-gray-400' : '' }}">
                                {{ $step->description }}
                            </span> --}}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <x-modal name="edit-idea" title="Edit Idea">
    <x-create-idea-modal :idea="$idea" />
    </x-modal>
</x-layout>
