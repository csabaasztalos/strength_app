<x-layout>

    <x-form title="Create a program" description="Don't rush, think it through." action="{{ route('program.store') }}" size="max-w-4xl" file="multipart/form-data">
        <x-program.program-details/>
        
    </x-form>
</x-layout>