
<dialog class="backdrop:bg-black/50 backdrop:backdrop-blur-xs m-auto" style="background: transparent !important; border: 0 !important; padding: 0 !important;"  id="editExerciseModal">
    <div class="rounded-xl overflow-hidden max-w-2xl max-h-[80dvh] mx-auto shadow-2xl">
        <x-card class="w-full h-full overflow-hidden relative">
            <div class="flex items absolute top-5 right-5"><a class="btn btn-outlined text-gray-500" id="closeEditModal">X</a></div>
            <x-form
                method="PATCH"
                action="{{ route('exercise.update') }}"
                size="max-w-2xl"
                title="Update exercise"
                height="max-w-2xl max-h-[80dvh]"
            >
                <x-form.field type="hidden" id="exerciseId" name="edit_exercise[id]" value=""/>

                <div class="flex-items items-center">
                    <x-form.field
                        label="Name"
                        name="edit_exercise[name]"
                        id="exerciseName"
                        required="required"
                        placholder="Example name"
                        value=""
                        dataTest="editName"
                    />
        
                    <div class="space-y-2">
                        <label class="label mt-2" for="exerciseDescription">Description</label>
                        <textarea
                            class="input min-h-40"
                            id="exerciseDescription"
                            name="edit_exercise[description]"
                            placholder="Example description"
                            data-test="editDescription"
                            value=""></textarea>
                    </div>

                    <div class="relative w-full">
                        <p class="label my-2">Percentage based on</p>
                        <input
                            id="editExerciseSearch"
                            placholder="Percentage based on"
                            value=""
                            class="input exerciseSearch w-full"
                        />

                        <ul id="exerciseResults" class="absolute left-0 top-full z-50 w-full max-h-40 overflow-y-auto bg-white divide-y divide-gray-200">
                        </ul>
                    </div>

                    <div>
                        <div class="label mt-2">Category</div>
                        <div class="grid grid-cols-3 mt-2 gap-1 md:grid-cols-4">
                            @foreach (App\ExerciseCategory::cases() as $category)
                            <button
                                type="button"
                                data-test="category-edit-{{ $category->value }}"
                                class="editCategory btn btn-outlined flex-1 h-10 bg-gray-400 text-white hover:!bg-gray-600"
                                value="{{ $category->value }}">
                                {{ $category->label() }}
                            </button>
                        @endforeach
                         <x-form.field
                            required="required"
                            name="edit_exercise[category]"
                            id="edit_category"
                            type="hidden"
                            value=""
                        />

                        <x-form.field
                            name="edit_exercise[percentage_based_on_exercise_id]"
                            id="percentageBase"
                            type="hidden"
                            value=""
                        />
                    </div>

                    <div><button data-test="saveExercise" type="submit" class="btn btn-primray mt-2 mb-2">Save</button></div>
                </div>
            </x-form>
        </x-card>
    </div>
</dialog>
