<x-layout>
    <x-form method="POST" action="{{ route('profile.update') }}"  title="Edit Profile" description="Edit your account !">
        @csrf
        @method('PATCH')
        <x-field name="name" label="Full Name" :value="auth()->user()->name" required />
        <x-field name="email" label="Email Address" type="email" :value="auth()->user()->email" required />
        <x-field name="password" label="New Password (optional)" type="password" />
        <x-field name="password_confirmation" label="Confirm new password" type="password" />
        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
            Update Account
        </button>
    </x-form>
</x-layout>
