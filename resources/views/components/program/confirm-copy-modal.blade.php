@props(['program'])

<dialog class="backdrop:bg-black/50 backdrop:backdrop-blur-xs m-auto" style="background: transparent !important; border: 0 !important; padding: 0 !important;"  id="confirmCopy">
    <div class="rounded-xl overflow-hidden max-w-2xl max-h-[80dvh] mx-auto shadow-2xl">
        <x-card class="w-full h-full overflow-hidden relative">
            <div class="flex items absolute top-5 right-5"><a class="btn btn-outlined text-gray-500 modalClose">X</a></div>
            <form
                action="{{ route('program.copy_weeks', $program) }}"
                method="POST"
                class="max-w-2xl max-w-2xl max-h-[80dvh]"
                id="applyForm"
            >
                @csrf
                @method('PATCH')
                <div class="flex flex-col gap-2 mt-2">
                    <h1 class="text-2xl font-bold">Apply to All weeks</h1>
                    <div class="text-muted-foreground">If you proceed, all the exercises with their data (sets, reps, ...) 
                    will be applied to all other weeks, make sure you saved the program before this update. 
                    This copy-paste won't update the program details or won't add any new exercises!
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-primray mt-2 mb-2">Proceed</button>
                        <a class="btn btn-outlined text-white bg-red-500 hover:bg-red-800 mt-2 mb-2 modalClose">Go back</a>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</dialog>