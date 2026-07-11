<x-layout>
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Ideas</h1>
            <a href="{{ route('ideas.create') }}" class="btn btn-primary">+ New Idea</a>
        </div>

        @forelse ($ideas as $idea)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-4">
                <div class="flex justify-between items-start">
                    <a href="{{ route('ideas.show', $idea) }}" class="block flex-1">
                        <h2 class="text-xl font-semibold hover:text-blue-600">{{ $idea->title }}</h2>
                    </a>
                <x-status-label :status="$idea->status" />
                </div>
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
</x-layout>
