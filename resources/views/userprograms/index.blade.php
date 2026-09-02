<x-layout>
    <div class="w-full max-w-7xl mt-10 mb-6 mx-auto md:mt-6">
        <h1 class="font-bold text-2xl mt-6 mb-6">Your current programs</h1>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 mt-">
            @forelse ($programs as $program)
                <x-program.user.user-program-card
                    :program="$program"
                />
            @empty
            <div class="w-full text-left">You haven't started any programs yet.<br> Check the available programs
                <a class="underline" href="{{ route('programs') }}"> here.</a>
                </div>
            @endforelse
        </div>
         <div id="pageNumbers" class="mt-1 flex gap-2">
                {{ $programs->links() }}
        </div>
    </div>

    <x-program.user.cancel-modal/>

</x-layout>


