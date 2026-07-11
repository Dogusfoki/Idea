<x-layout>
    <div class="text-center mt-20">
        <h1 class="text-4xl font-bold">Welcome to Ideas App</h1>
        <p class="text-gray-500">Your ideas management platform</p>
    </div>
    @auth
        <a href="{{ route('ideas.index') }}" class="btn btn-primary">Go to my idea</a>
        @else
    @endauth
</x-layout>
