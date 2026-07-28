<nav class="border-b border-border px-6 sticky top-0 bg-background">
    <div class="mx-auto max-w-7xl h-16 flex items-center justify-between">
        <div class="flex gap-x-5 items-center">
            <a href="/"><h3 class="font-bold text-xl text-center">Home</h3></a>
            @auth ()
                <a href="/programs"><h3 class="text-md text-lg text-center">Programs</h3></a>
                <a href="/program/create"><h3 class="text-md text-lg text-center">New program</h3></a>
                <a href="/exercises"><h3 class="text-md text-lg text-center">Exercises</h3></a>
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
