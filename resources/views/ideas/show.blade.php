<x-layout>
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <h1 class="text-3xl font-bold">{{ $idea->title }}</h1>
                <x-status-label :status="$idea->status" />
            </div>

            <p class="text-gray-600 dark:text-gray-300 mt-4">{{ $idea->description }}</p>

            <div class="mt-6 flex items-center gap-4 text-sm text-gray-500">
                <span>Created {{ $idea->created_at->diffForHumans() }}</span>
                <span>•</span>
                <span>Updated {{ $idea->updated_at->diffForHumans() }}</span>
            </div>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('ideas.edit', $idea) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('ideas.destroy', $idea) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error" onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>
                <a href="{{ route('ideas.index') }}" class="btn btn-ghost">Back</a>
            </div>
        </div>
    </div>
</x-layout>
