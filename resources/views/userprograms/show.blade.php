<x-layout>
    <div class="w-full mx-auto max-w-7xl px-4 mt-10">
        <div class="flex items-center justify-between">
            <div class="mt-4 mb-4">
                <h1 class="text-3xl font-bold">{{ $program->program->name }}</h1>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-outlined bg-[oklch(0.25_0.03_268)] text-white hover:none cursor-default">
                    {{ $program->program->category->label() }}
                </button>
            </div>
        </div>


       <x-program.user.show-day
            :programDays="$programDays"
            :program="$program"
            week_number="{{ $week }}"
            day_number="{{ $day }}"
            next_day="{{ $nextDay }}"
            next_week="{{ $nextWeek }}"
            previous_day="{{ $prevDay }}"
            previous_week="{{ $prevWeek }}"
        />
    </div>
</x-layout>