
<x-layout title="Sign In">
    <x-form
        title="Sign In"
        description="Glad to have you back."
        action="/signin">

        @csrf
        <x-form.field label="Email" name="email" type="email" required="required"/>
        <x-form.field label="Password" name="password" type="password" required="required"/>
        <button class="btn btn-primary mt-2 w-full" name="signin" id="signin" type="submit" data-test="login-button">Sign In</button>

        <p class="text-muted-foreground">Haven't registered yet? <a class="underline mt-2" href="{{ route('register') }}">Click here</a></p>

    </x-form>
</x-layout>
