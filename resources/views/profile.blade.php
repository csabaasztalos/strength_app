<x-layout title="Profile">
    <x-form
        title="Your Profile"
        description="Edit your profile here."
        method="PATCH"
        action="/profile"
        >
        <x-form.field label="Your current name" name="name" value="{{ $user->name }}"/>
        <x-form.field label="Your current email" name="email" type="email" value="{{ $user->email }}"/>
        <x-form.field label="New password" name="newPassword" type="password"/>
        <button type="submit" name="save" class="btn btn-primary w-full mt-2">Save</button>
    </x-form>
</x-layout>
