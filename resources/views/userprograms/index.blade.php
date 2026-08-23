<x-layout>
    <h1 class="font-bold text-2xl mt-10 mb-6 md:mt-6 max-w-7xl mx-auto">Your current programs</h1>
    <div class="w-full max-w-7xl mx-auto flex flex-wrap gap-6 justify-center">
        @foreach ($programs as $program)
            <x-program.user.user-program-card
                :program="$program"
            />
        @endforeach
    </div>

    <x-program.user.cancel-modal/>

</x-layout>


