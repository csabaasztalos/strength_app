<x-layout>
    <div class="w-full w-max-7xl mt-10 mb-6 mx-auto md:mt-6">
        <h1 class="text-3xl font-bold ">{{ $program->name }}</h1>
        <div>
            @error('status')
                <div class="text-sm text-red-500 bg-red-200 border-none rounded-md py-2 px-2 w-1/2">
                    {{ $message }}
                </div>
            @enderror
        </div>
       <div class="flex items-center justify-between">
            <div class="mt-4 mb-4">
                @if ($program->status === App\ProgramStatus::DRAFT)
                    <a class= "btn border cursor-default
                        {{"bg-gray-500/10 text-gray-500 border-gray-500/20"}}">
                @elseif ($program->status === App\ProgramStatus::HIDDEN)
                    <a class= "btn border cursor-default
                        {{"border bg-yellow-500/10 text-yellow-500 border-yellow-500/20" }}">
                @else
                    <a class= "btn border cursor-default
                        {{"border bg-green-500/10 text-green-500 border-green-500/20" }}">
                @endif
                        {{ $program->status->label() }}
                    </a>
            </div>
            <div class="flex items-end gap-2">
                @if ($program->status === App\ProgramStatus::ACTIVE)
                    <button type="submit" class="btn btn-outlined bg-black text-white" id="openStartModal" data-test="startProgram">
                        Start Program
                    </button>
                @endif
                @if ($user->role === App\UserRoles::COACH)
                    @if($program->status == App\ProgramStatus::DRAFT)
                        <a href="{{ route('program.edit', $program) }}" class="btn btn-outlined bg-yellow-500/40">
                            Edit <x-icons.external/>
                        </a>

                        <form method="POST" action="{{ route('program.publish', $program) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outlined bg-green-500/40" data-test="publishProgram">
                                    Publish<x-icons.check/>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('program.delete', $program) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outlined bg-red-500/40" data-test="deleteProgram">
                                Delete <x-icons.trash/>
                            </button>
                        </form>
                    @elseif ($program->status === App\ProgramStatus::ACTIVE)
                        <form method="POST" action="{{ route('program.hide', $program) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outlined bg-gray-500/40" data-test="hideProgram">
                                Hide<x-icons.hide/>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('program.draft', $program) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outlined bg-gray-500/40" data-test="draftProgram">
                                Draft<x-icons.draft/>
                            </button>
                        </form>
                    @endif
                @endif
            </div>
       </div>

        @if ($program?->image_path)
            <x-card class="mb-2">
                <img src="{{ Storage::url($program->image_path) }}" alt="program" class="max-h-180 mx-auto rounded-md block"
                    data-test="program-image" id="imageDisplay">
            </x-card>
        @endif
    
        @if ($program->description)
            <x-card>
                <h1 class="text-lg font-bold">Program description</h1>
                <p class="text-muted-foreground">{{ $program->description }}</p>
            </x-card>
        @endif
   
        <x-program.exercises :programDays="$programDays"></x-program.exercises>
    </div>
    <x-program.user.start-modal :program="$program" :exerciseMaxes="$exerciseMaxes"/>
</x-layout>
