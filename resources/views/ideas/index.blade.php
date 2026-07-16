<x-layout>
<div class="flex flex-wrap gap-2 mb-6">
    {{-- All Button --}}
    <a href="{{ route('ideas.index', ['status' => 'all']) }}"
       class="btn btn-sm {{ request('status') === 'all' || !request('status') ? 'btn-primary' : 'btn-ghost' }}">
        All
        <span class="badge badge-sm">{{ $statusCounts['all'] ?? 0 }}</span>
    </a>

    {{-- Button for every status --}}
    @foreach(\App\Enums\IdeaStatus::cases() as $status)
        <a href="{{ route('ideas.index', ['status' => $status->value]) }}"
           class="btn btn-sm {{ request('status') === $status->value ? 'btn-primary' : 'btn-ghost' }}">
            {{ $status->label() }}
            <span class="badge badge-sm">{{ $statusCounts[$status->value] ?? 0 }}</span>
        </a>
        @endforeach
    </div>



    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Ideas</h1>
            <button
            type="button"
            x-data @click="$dispatch('open-modal', {name:'create-idea'})" class="btn btn-primary">
            + New Idea
        </button>
    </div>

    @forelse ($ideas as $idea)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-4">
        <div class="flex justify-between items-start">
            <a href="{{ route('ideas.show', $idea) }}" class="block flex-1">
                        @if($idea->image_path)
                        <div class="-mx-4 -mt-4 rounded-t-lg overflow-hidden mb-4">
                            <img src="{{ asset('storage/' . $idea->image_path) }}"
                                alt="{{ $idea->title }}"
                                class="w-full h-60 object-cover">
                        </div>
                        @endif
                        <h2 class="text-xl mb-4 font-semibold hover:text-blue-600">{{ $idea->title }}</h2>
                    </a>
                </div>
                <x-status-label :status="$idea->status" />
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    {{ Str::limit($idea->description, 150) }}
                </p>
                <div class="mt-4 flex items-center gap-4 text-sm text-gray-500">
                    <span>{{ $idea->created_at->diffForHumans() }}</span>
                    <div class="flex gap-2">
                        <a href="{{ route('ideas.edit', $idea) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-gray-500">No ideas yet. Create your first idea!</p>
                <a href="{{ route('ideas.create') }}" class="btn btn-primary mt-4">
                    Create Idea
                </a>
            </div>
        @endforelse
    </div>
<x-modal name="create-idea" title="New idea">
            <x-create-idea-modal />
</x-modal>
</x-layout>
