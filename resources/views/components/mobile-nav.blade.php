<nav class="md:hidden border-b border-border w-full mx-auto fixed bottom-0 bg-background shadow-sm z-100">
    <div class="mx-auto h-16 flex items-center justify-around gap-0">
        <a class="px-4 flex flex-col items-center" href="/">
            <x-icons.home/>
            <p class="text-[10px]">Home</p>
        </a>
        <div class="w-0.5 bg-gray-300 h-10"></div>
        @guest()
        <a class="px-4 flex flex-col items-center" href="{{ route('programs') }}">
            <x-icons.black-profile/>
            <p class="text-[10px]">Sign in</p>
        </a>
        @endguest
        @auth ()
            <a class="px-4 flex flex-col items-center" href="{{ route('programs') }}">
                <x-icons.program/>
                <p class="text-[10px]">Library</p>
            </a>
            <div class="w-0.5 bg-gray-300 h-10"></div>
            <a class="px-4 flex flex-col items-center" href="{{ route('user.programs', Auth::user()) }}">
                <x-icons.my-programs/>
                <p class="text-[10px]">Programs</p>
            </a>

            @if (Auth::user()->role === App\UserRoles::COACH)
                <div class="w-0.5 bg-gray-300 h-10"></div>
                <a class="px-4 flex flex-col items-center" href="{{ route('exercises') }}">
                    <x-icons.exercise/>
                    <p class="text-[10px]">Exercises</p>
                </a>
                <div class="w-0.5 bg-gray-300 h-10"></div>
                <a class="px-4 flex flex-col items-center" href="{{ route('program.create') }}">
                    <x-icons.create/>
                    <p class="text-[10px]">Create</p>
                </a>
            @endif
        @endauth
        </a>
    </div>
</nav>
