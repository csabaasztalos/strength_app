
<dialog class="backdrop:bg-black/50 backdrop:backdrop-blur-xs m-auto" style="background: transparent !important; border: 0 !important; padding: 0 !important;"  id="newExerciseModal">
    <div class="rounded-xl overflow-hidden max-w-2xl max-h-[80dvh] mx-auto shadow-2xl">
        <x-card class="w-full h-full overflow-hidden relative">
            <div class="flex items absolute top-5 right-5"><a class="btn btn-outlined text-gray-500" id="modalClose">X</a></div>
            <x-form
                action="{{ route('exercise.store') }}"
                size="max-w-2xl"
                title="Create exercise"
                height="max-w-2xl max-h-[80dvh]"
            >
                <div>
                    <x-form.field
                        label="Name"
                        name="exercise[name]"
                        required="required"
                        placholder="Exemple name"
                        dataTest="exerciseName"
                    />
        
                    <div class="space-y-2">
                         <label class="label mt-2" for="exercise[description]">Description</label>
                         <textarea class="input min-h-40"
                            id="exercise[description]"
                            name="exercise[description]"
                            placholder="Exemple description"
                            data-test="exerciseDescription"></textarea>
                    </div>
        
                    <div>
                        <div class="label mt-2">Category</div>
                        <div class="grid grid-cols-3 md:grid-cols-4 mt-2">
                            @foreach (App\ExerciseCategory::cases() as $category)
                            <button
                                type="button"
                                data-test="category-new-{{ $category->value }}"
                                class="category btn btn-outlined flex-1 h-10 bg-gray-400 text-white hover:!bg-gray-600"
                                value="{{ $category->value }}">
                                {{ $category->label() }}
                            </button>
                        @endforeach
                         <x-form.field
                            required="required"
                            id="category"
                            name="exercise[category]"
                            type="hidden"
                            value=""
                            dataTest="programCategory"
                        />
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primray mt-2 mb-2" data-test="createExercise">Save</button>
                    </div>
                </div>
            </x-form>
        </x-card>
    </div>
</dialog>
