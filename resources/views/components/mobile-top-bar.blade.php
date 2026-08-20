<nav class="md:hidden border-b border-border w-full mx-auto fixed top-0 bg-black mb-10 z-100">
    <div class="mx-auto max-w-7xl h-13 flex items-center justify-between px-4">
        <div class="flex gap-1 items-center">
            <img class="w-8" src="{{ Storage::url('assets/dogpacklogo.png') }}" alt="logo">
            <a href="{{ route('index') }}"><h1 class="font-bold text-xl text-white">DogPack</h1></a>
        </div>
        
        <div class="flex gap-x-5">
            @auth
                <form action="/signout" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-2 items-center">
                        <a class="px-4" href="{{ route('profile.update') }}">
                            <x-icons.profile/>
                        </a>
                        <button type="submit" class="btn btn-primary">Sign Out</button>
                    </div>
                </form>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                <a href="{{ route('login') }}" class="btn btn-outlined bg-white">Sign In</a>
            @endauth
            
        </div>
    </div>
</nav>