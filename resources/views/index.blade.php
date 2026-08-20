<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" type="image/x-icon" href="{{ Storage::url('assets/dogpacklogo.png') }}">
    </head>

    <body class="bg-background text-foreground min-h-screen overflow-x-hidden">
        
        <x-nav/>
        <x-mobile-top-bar/>

        <main class="mx-auto h-full w-full bg-black pt-13 md:pt-6">
            <div class="mx-auto grid grid-cols-1 md:grid-cols-2 text-white mb-6">
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
            
            <div class="max-w-7xl mx-auto my-20 flex flex-col">
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
                    <div class="mx-10">
                        <img
                        src="{{ Storage::url('assets/deadlift.jpg') }}"
                        alt="deadlift"
                        class="w-full h-100 lg:h-150 object-cover"
                        >
                    </div>
                </div>

                <div class="flex flex-col-reverse md:grid md:grid-cols-2 text-white mt-20">
                    <div class="mx-10">
                        <img
                        src="{{ Storage::url('assets/deadlift.jpg') }}"
                        alt="deadlift"
                        class="w-full h-100 lg:h-150 object-cover"
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

                <div class="grid grid-cols-1 md:grid-cols-2 text-white mt-20">
                        <div class="flex flex-col mx-10">
                        <h1 class="font-bold text-2xl lg:text-3xl mt-6 text-primary">Easy, quick access</h1>
                        <h1 class="font-bold text-lg lg:text-xl mt-6 text-muted-foreground mb-6 lg:mb-0">
                            This application is design for quick and relaibe use.
                            Choose between dozens of well tailored programs.
                        </h1>
                    </div>
                    <div class="mx-10">
                        <img
                        src="{{ Storage::url('assets/deadlift.jpg') }}"
                        alt="deadlift"
                        class="w-full h-100 lg:h-150 object-cover"
                        >
                    </div>
                </div>
            </div>
            <!--
            <div class="w-full mx-auto text-white relative">
                <img
                    src="{{ Storage::url('assets/gurph.jpg') }}"
                    alt="deadlift"
                    class="w-3/4 mx-auto md:h-175 object-fit backdrop-blur-sm"
                >
                <div class="absolute top-0 left-0 w-full md:h-175 bg-black opacity-50"></div>
                <div class="absolute top-0 left-0 w-1/5 md:h-175 bg-black opacity-60"></div>
                <div class="absolute top-0 left-0 w-1/6 md:h-175 bg-black opacity-70"></div>
                <div class="absolute top-0 left-0 w-1/7 md:h-175 bg-black opacity-80"></div>
                <div class="absolute top-0 right-0 w-1/5 md:h-175 bg-black opacity-60"></div>
                <div class="absolute top-0 right-0 w-1/6 md:h-175 bg-black opacity-70"></div>
                <div class="absolute top-0 right-0 w-1/7 md:h-175 bg-black opacity-80"></div>
                <div class="z-50 absolute top-[50%] left-[50%] w-50 translate-x-[-50%] translate-y-[-50%] text-center">
                    <h1 class="font-bold text-3xl mb-2">Sign up now!</h1>
                    <button class="btn btn-primary w-20 left-0">Sign Up</button>
                    <button class="btn bg-white text-black w-20 left-0 hover:bg-gray-300">Sign Up</button>
                </div>
            </div>-->
        </main>


        <x-mobile-nav />
        @session('success')
            <div id="message" class="bg-primary px-4 py-3 fixed bottom-4 right-4 rounded-lg">{{ $value }}</div>
        @endsession
        @session('error')
            <div id="message" class="bg-red-500 px-4 py-3 fixed bottom-4 right-4 rounded-lg text-white">{{ $value }}</div>
        @endsession
    </body>
</html>
