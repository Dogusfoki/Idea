<x-layout>
    <x-form method="Post" action="/register" title="Create Account" description="Start tracking your ideas today">
        <x-field name="name" label="Full Name" required />
        <x-field name="email" label="Email Address" type="email" required />
        <x-field name="password" label="Password" type="password" required />

        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
            Create Account
        </button>
    </x-form>
</x-layout>
