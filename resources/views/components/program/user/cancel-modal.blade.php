<dialog class="backdrop:bg-black/50 backdrop:backdrop-blur-xs m-auto" style="background: transparent !important; border: 0 !important; padding: 0 !important;"  id="cancelConfirm">
    <div class="rounded-xl overflow-hidden max-w-2xl max-h-[80dvh] mx-auto shadow-2xl">
        <x-card class="w-full h-full overflow-hidden relative">
            <div class="flex items absolute top-5 right-5"><a class="btn btn-outlined text-gray-500 modalClose">X</a></div>
            <form
                action="{{ route('user_program.cancel') }}"
                method="POST"
                class="max-w-2xl max-w-2xl max-h-[80dvh]"
            >
                @csrf
                @method('PATCH')
                <div class="flex flex-col gap-2 mt-2">
                    <h1 class="text-2xl font-bold">Cancel program</h1>
                    <div class="text-muted-foreground">This is not reversible, your progression will be lost!<br>
                    Feel free to start again, or start a new program!</div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-outlined text-white bg-red-500 hover:bg-red-800 mt-2 mb-2">Proceed</button>
                        <a class="btn btn-primray mt-2 mb-2 modalClose">Go back</a>
                    </div>
                </div>
            <x-form.field id="cancel_program_id" type="hidden" name="cancel_program[id]"/>
            </form>
        </x-card>
    </div>
</dialog>