<x-layout title="Verify email">
    <h1 class="font-bold text-3xl lg:text-5xl mt-13 lg:mt-0">Password Reset</h1>
    <div>
        <p class="text-lg lg:text-xl mt-2">
            Send a password reset link to your accounts email address.
        </p>
    </div>

    <div class="mt-6 max-w-5xl">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <x-form.field
                label="Your accounts email address:"
                name="email"
                type="email"
                class="input w-1/2"
                placeholder="example@example.com"
            />
            <button type="submit" class="btn btn-primary my-2">Send email</button>
        </form>
    </div>
</x-layout>