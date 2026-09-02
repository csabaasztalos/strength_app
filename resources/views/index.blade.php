<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/x-icon" href="{{ Storage::url('assets/dogpacklogo.png') }}">
    </head>

    <body class="bg-background text-foreground min-h-screen overflow-x-hidden mx-0 my-0 px-0 py-0">
        
        <x-nav.nav/>
        <x-nav.mobile-top-bar/>
        
        <main class="mx-auto h-full w-full bg-black pt-13 md:pt-6 pb-0">
            <div class="mx-auto grid size-[80%] grid-cols-1 md:grid-cols-2 text-white mb-6">
                <div class="flex flex-col text-center md:text-left px-10 lg:px-20 justify-center">
                    <h1 class="text-5xl lg:text-7xl font-bold">Train smarter,</h1>
                    <h1 class="text-2xl lg:text-5xl font-bold">progress faster!</h1>
                    <hr class="my-4 lg:my-6 border-3 w-1/2 border-primary mx-auto lg:ml-0">
                    <h4 class="text-xl lg:text-3xl font-bold">Adaptive programs and expert-designed workouts to take your performance to the next level.</h4>
                    <h1 class="text-xl lg:text-3xl font-bold mt-4 lg:mt-6">Start today!</h1>
                    <a class="btn btn-primary my-4 w-fit mx-auto lg:ml-0">Sing up here.</a>
                </div>

                <div class="w-full">
                    <img
                        src="{{ Storage::url('assets/deadlift.jpg') }}"
                        alt="deadlift"
                        class="w-full h-full object-fit"
                    >
                </div>
            </div>
            
            <div class="max-w-7xl mx-auto mt-20 flex flex-col">
                <h1 class="font-bold text-4xl lg:text-6xl mt-0 lg:mt-6 px-10 lg:px-0 text-white">Find the perfect program for you</h1>
                <hr class="my-6 border-3 w-1/2 border-primary mx-10 lg:mx-0">

                <div class="grid grid-cols-1 md:grid-cols-2 text-white">
                        <div class="flex flex-col mx-10">
                        <h1 class="font-bold text-2xl lg:text-3xl mt-6 text-primary">Proven programs</h1>
                        <h1 class="font-bold text-lg lg:text-xl mt-6 text-muted-foreground mb-6 lg:mb-0">
                            Train with confidence, use our programs tested by thousands of atheltes accross
                            Weightlifting, Powerlifting, Crossfit and General strength.<br>
                            Backed with years of coaching experience and training.
                        </h1>
                    </div>
                    <div class="mx-10 flex justify-center">
                        <img
                        src="{{ Storage::url('assets\phone1.1.png') }}"
                        alt="screenshot"
                        class="w-67 h-112 lg:h-150 lg:w-89 object-cover"
                        >
                    </div>
                </div>

                <div class="flex flex-col-reverse md:grid md:grid-cols-2 text-white mt-20">
                    <div class="mx-10 flex justify-center">
                        <img
                        src="{{ Storage::url('assets\phone2.png') }}"
                        alt="screenshot"
                        class="w-67 h-112 lg:h-150 lg:w-89 object-cover"
                        >
                    </div>

                    <div class="flex flex-col mx-10">
                        <h1 class="font-bold text-2xl lg:text-3xl mt-6 text-primary">Track your progress</h1>
                        <h1 class="font-bold text-lg lg:text-xl mt-6 text-muted-foreground mb-6 lg:mb-0">
                            Track your progression anytime, anywhere. Run 2 trusted strength program at the same time.
                            Save your progression and analyze it later.
                            
                        </h1>
                    </div>
                </div>

                <div class="flex flex mx-10 mt-20 mb-10 justify-center">
                    <div class="flex flex-col items-center">
                        <h1 class="font-bold text-2xl lg:text-3xl mt-6 text-primary">Easy, quick access</h1>
                        <h1 class="font-bold text-lg lg:text-xl mt-6 text-muted-foreground mb-6 lg:mb-0">
                            This application is designed for quick and relaibe use.
                        </h1>
                        <h1 class="font-bold text-lg lg:text-xl text-muted-foreground mb-6 lg:mb-0">
                            Choose between dozens of well tailored programs.
                        </h1>
                    </div>
                </div>
                <div class="flex flex mx-10 mb-10 justify-center">
                    <p class="text-muted-foreground">© Copyright DogPack 2026</p>
                </div>
            </div>
        </main>
        <x-nav.mobile-nav />
    </body>
</html>
