<x-layout>
    <div class="w-full max-w-7xl mt-10 mb-6 mx-auto md:mt-6">
        <x-form 
            title="Create a program"
            description="Don't rush, think it through."
            action="{{ route('program.store') }}"
            size="max-w-4xl" 
            file="multipart/form-data"
        >
            <x-program.program-details/>
        </x-form>
    </div>
    
</x-layout>