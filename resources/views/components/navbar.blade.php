<nav class="bg-white border-b border-gray-200 px-4 py-3">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-xl font-bold text-gray-800">Ideas</a>

        <div class="flex items-center gap-4">
            @auth
                <span class="text-gray-600">{{ auth()->user()->name }}</span>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        Logout
                    </button>
                </form>
            @else
                <a href="/login" class="text-gray-600 hover:text-gray-800">Sign In</a>
                <a href="/register" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>
