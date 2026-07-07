<x-layout>
    <x-form method="POST" action="/login" title="Welcome Back" description="Sign in to your account">
        <x-field name="email" label="Email Address" type="email" required />
        <x-field name="password" label="Password" type="password" required />
        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
            Sign In
        </button>
    </x-form>
</x-layout>
