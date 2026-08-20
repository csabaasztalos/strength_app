<x-layout title="Verify email">
    <h1 class="font-bold text-3xl lg:text-5xl mt-13 lg:mt-0">Verifiy your account!</h1>
    <div>
        <?php $message = "" ?>
        @session('error')
                <?php $message = $value ?>
        @endsession

        @if ($message)
            <p class="text-lg lg:text-xl mt-2">
                {{ $message }}
            </p>
        @else
            <p class="text-lg lg:text-xl mt-2">
                Check your emails to verify your regisitered account in order to use the provided features.
            </p>
        @endif

        
    </div>

    <div class="mt-10">
        <p class="text-lg lg:text-xl mt-2">
            Email expired? Or can't find it?
        </p>
        <p class="text-lg lg:text-xl mt-2">
            Send a new one here:
        </p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary my-2">Send Verification</button>
        </form>
       
    </div>
</x-layout>