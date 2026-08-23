
<x-layout title="Sign Up">
    <div class="w-full max-w-7xl mt-10 mb-6 mx-auto md:mt-6">
        <x-form
            title="Sign Up"
            description="Get stronger today."
            action="{{ route('register') }}">
    
            @csrf
            <x-form.field label="Name" name="name" required="required"/>
            <x-form.field label="Email" name="email" type="email" required="required"/>
            <x-form.field label="Password" name="password" type="password" required="required"/>
            <x-form.field label="Confrim your password" name="password_confirmation" type="password" required="required"/>
            <button class="btn btn-primary mt-2 w-full" name="signup" id="signup" type="submit" data-test="register-button">Sign Up</button>
        </x-form>
    </div>
    
</x-layout>
