<x-layout title="Profile">
    <x-form
        title="Your Profile"
        description="Edit your profile here."
        method="PATCH"
        action="{{ route('profile.update') }}"
        >
        <x-form.field label="Your current name" name="user[name]" value="{{ $user->name }}"/>
        <x-form.field label="Your current email" name="user[email]" type="email" value="{{ $user->email }}"/>
        <x-form.field label="New password" name="user[password]" type="password"/>
        <x-form.field label="Confrim new password" name="user[password_confirmation]" type="password"/>
        <x-form.field label="Your current password" name="user[current_password]" type="password"/>
        <button type="submit" name="save" class="btn btn-primary w-full mt-2">Save</button>
    </x-form>

    <div class="flex items-center justify-center">
        @session('status')
            <p class="text-xl mt-10">{{ $value }}</p>
        @endsession
    </div>
</x-layout>
