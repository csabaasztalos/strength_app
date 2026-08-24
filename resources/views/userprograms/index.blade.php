<x-layout>
    <div class="w-full max-w-7xl mt-10 mb-6 mx-auto md:mt-6">
        <h1 class="font-bold text-2xl mt-6 mb-6">Your current programs</h1>
        <div class="mx-auto flex flex-wrap gap-6 justify-center">
            @foreach ($programs as $program)
                <x-program.user.user-program-card
                    :program="$program"
                />
            @endforeach
        </div>
    </div>

    <x-program.user.cancel-modal/>

</x-layout>


