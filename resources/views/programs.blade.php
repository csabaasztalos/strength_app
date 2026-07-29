<x-layout>
    <div class="w-7xl mt-6 mb-6 mx-auto">
        <div class="font-bold text-2xl mb-6"><h1>Current programs</h1></div>
        <details class="relative group mb-6 inline-block">
            <summary class="list-none cursor-pointer rounded-xl bg-[oklch(0.25_0.03_268)] text-white px-4 py-3 select-none flex items-center justify-between">
                @if (request('category'))
                    {{ App\ProgramCategory::tryFrom(request('category'))
                     ? (App\ProgramCategory::from(request('category')))->label()
                     : 'Category'
                     }}
                @else
                    All categories
                @endif
                <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </summary>

            <div class="absolute left-0 mt-2 rounded-xl bg-[oklch(0.25_0.03_268)] border border-white/10 shadow-lg p-1 space-y-1 z-50">
                <a href="{{ route('programs', Arr::except(request()->query(), 'category'))}}"
                    class="block px-3 py-2 rounded-lg text-white hover:bg-white/10"
                    value="">All categories</a>
                @foreach ($categories as $category)
                    <a href="{{ route('programs', array_merge(request()->query(), [
                        'category' => $category
                    ])) }}"
                    class="filterOption block px-3 py-2 rounded-lg text-white hover:bg-white/10"
                    value="{{ $category }}">{{ $category->label() }}</a>
                @endforeach
            </div>
        </details>

        <details class="relative group mb-6 inline-block">
            <summary class="list-none cursor-pointer rounded-xl bg-[oklch(0.25_0.03_268)] text-white px-4 py-3 select-none flex items-center justify-between">
                @if ($frequencies->contains((int) request('duration')))
                    {{ request('duration') . ' weeks'}}
                @else
                    All durations
                @endif
                <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </summary>

            @dump($errors);

            <div class="absolute left-0 mt-2 rounded-xl bg-[oklch(0.25_0.03_268)] border border-white/10 shadow-lg p-1 space-y-1 z-50">
                <a href="{{ route('programs', Arr::except(request()->query(), 'duration'))}}"
                    class="block px-3 py-2 rounded-lg text-white hover:bg-white/10"
                    value="">All durations</a>
                @foreach ($durations as $weeks)
                    <a href="{{ route('programs', array_merge(request()->query(), [
                        'duration' => $weeks
                    ])) }}"
                    class="filterOption block px-3 py-2 rounded-lg text-white hover:bg-white/10"
                    value="{{ $weeks }}">{{ $weeks }} week</a>
                @endforeach
            </div>
        </details>

        <details class="relative group mb-6 inline-block">
            <summary class="list-none cursor-pointer rounded-xl bg-[oklch(0.25_0.03_268)] text-white px-4 py-3 select-none flex items-center justify-between">
                @if ($frequencies->contains((int) request('frequency')))
                    {{ request('frequency') . ' days per week'}}
                @else
                    All frequencies
                @endif
                <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </summary>

            <div class="absolute left-0 mt-2 rounded-xl bg-[oklch(0.25_0.03_268)] border border-white/10 shadow-lg p-1 space-y-1 z-50">
                <a href="{{ route('programs', Arr::except(request()->query(), 'frequency'))}}"
                    class="block px-3 py-2 rounded-lg text-white hover:bg-white/10"
                    value="">All frequencies</a>
                @foreach ($frequencies as $days)
                    <a href="{{ route('programs', array_merge(request()->query(), [
                        'frequency' => $days
                    ])) }}"
                    class="filterOption block px-3 py-2 rounded-lg text-white hover:bg-white/10"
                    value="{{ $days }}">{{ $days }} days per week</a>
                @endforeach
            </div>
        </details>

        <div class="grid grid-cols-3 gap-6">
            @forelse ( $programs as $program)
            <x-card>
                <div>
                    <a href="{{ route('program.show', $program) }}">
                        <h3 class="text font-bold text-lg mb-2 flex gap-2">{{ $program->name }}<x-icons.arrow/></h3>
                    </a>
                </div>
                
                <div class="flex flex-row gap-6 mb-2">
                    <div>
                        @if ($program?->image_path)
                            <img src="{{ Storage::url($program->image_path) }}"
                            alt="program"
                            class="w-60 h-40 rounded-md mb-2 object-cover"
                            data-test="program-image">
                        @endif
                    </div>
                    <div>
                        <p><b>Category:</b> {{ $program->category->label() }}</p>
                        <p><b>Duration:</b> {{ $program->weeks }} weeks</p>
                        <p><b>Frequency:</b> {{ $program->days_per_week }} days per week</p>
                        <p><b>Published at:</b> {{ date_format($program->updated_at, "Y.m.d") }}</p>
                        <div
                            class="rounded rounded-lg px-3 inline-block mt-2
                            {{ $program->status == App\ProgramStatus::DRAFT ? "border bg-yellow-500/10 text-yellow-500 border-yellow-500/20" : "border bg-green-500/10 text-green-500 border-green-500/20" }}">
                            {{ $program->status }}
                        </div>
                    </div>
                </div>
                <div>
                    
                    <div class="text-muted-foreground">{{ $program->description ?? 'No description for this program.'}}</div>
                </div>
            </x-card>
            @empty
            <p>No programs fit the current filters. <a href="{{ route('programs') }}" class="underline"> Go Back.</a></p>
            @endforelse
        </div>
    </div>
</x-layout>