<x-layout>
    <div class="w-full max-w-7xl mt-10 mb-6 mx-auto md:mt-6">
        <div class="font-bold text-2xl mb-6"><h1>Current programs</h1></div>
        <details class="relative group mb-2 inline-block">
            <summary class="list-none cursor-pointer rounded-xl bg-[oklch(0.25_0.03_268)] text-white px-4 py-3 select-none flex items-center justify-between">
                @if (request('category'))
                    {{ App\ProgramCategory::tryFrom(request('category'))
                     ? (App\ProgramCategory::from(request('category')))->label()
                     : 'Category'
                     }}
                @else All categories @endif

                <x-icons.filter-arrow/>
            </summary>

            <x-filter title="All categories" type="category" route="programs" category="true"
                :options="$categories"
            />
        </details>

        <details class="relative group mb-2 inline-block">
            <summary class="list-none cursor-pointer rounded-xl bg-[oklch(0.25_0.03_268)] text-white px-4 py-3 select-none flex items-center justify-between">
                @if ($frequencies->contains((int) request('duration')))
                    {{ request('duration') . ' weeks'}}
                @else All durations @endif

                <x-icons.filter-arrow/>
            </summary>

            <x-filter title="All durations" type="duration" route="programs" optionName="weeks"
                :options="$durations"
            />
        </details>

        <details class="relative group mb-2 inline-block">
            <summary class="list-none cursor-pointer rounded-xl bg-[oklch(0.25_0.03_268)] text-white px-4 py-3 select-none flex items-center justify-between">
                @if ($frequencies->contains((int) request('frequency')))
                    {{ request('frequency') . ' days per week'}}
                @else All frequencies @endif

                <x-icons.filter-arrow/>
            </summary>

            <x-filter title="All frequencies" type="frequency" route="programs" optionName="days per week"
                :options="$frequencies"
            />
        </details>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3 mt-6">
            @forelse ( $programs as $program)
                @if(Auth::user()->role === App\UserRoles::ATHLETE && $program->status !== App\ProgramStatus::ACTIVE)
                    @continue
                @endif

                <x-program.program-card
                    :program="$program"
                />
            @empty
                <p>No programs fit the current filters. 
                    <a href="{{ route('programs') }}" class="underline"> Go Back.</a>
                </p>
            @endforelse
        </div>
    </div>
</x-layout>