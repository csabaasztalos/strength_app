<nav class="hidden md:block border-b border-border w-full mx-auto sticky top-0 bg-background">
    <div class="mx-auto max-w-7xl h-16 flex items-center justify-between">
        <div class="flex gap-x-5 items-center">
            <a href="/">
                <h3 class="font-bold text-xl text-center">
                    Home
                </h3>
            </a>
            <a href="{{ route('programs') }}"><h3 class="text-md text-lg text-center">Programs</h3></a>
            @auth ()
                <a href="{{ route('user.programs', Auth::user()) }}"><h3 class="text-md text-lg text-center">My programs</h3></a>
                @if (Auth::user()->role === App\UserRoles::COACH)
                    <a href="{{ route('exercises') }}"><h3 class="text-md text-lg text-center">Exercises</h3></a>
                    <a href="{{ route('program.create') }}"><h3 class="text-md text-lg text-center">New program</h3></a>
                @endif
            @endauth
        </div>
    
        <div class="flex gap-x-5">
            @auth
                <form action="/signout" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="/profile" class="btn btn-primary">Profile</a>
                    <button type="submit" class="btn btn-outlined">Sign Out</button>
                </form>
            @else
                <a href="/signup" class="btn btn-primary">Sign Up</a>
                <a href="/signin" class="btn bg-black">Sign In</a>
            @endauth
            
        </div>
    </div>
</nav>