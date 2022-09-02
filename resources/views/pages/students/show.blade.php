<x-app-layout>

    <x-slot name="title">| {{ __('Statistika učenika') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $student->name }} - {{ __('Statistika') }}</h2>
            <div class="mb-2 md:my-6">
                <a href="{{ route('students.index') }}" class="flex items-center justify-between w-full px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                    {{ __('Nazad') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="relative overflow-x-auto sm:rounded-lg">

            <div class="grid grid-rows sm:grid-cols-4 gap-4">
                @forelse ($student->lessons as $lesson )
                <div class="rounded-lg bg-gray-200 dark:bg-gray-800">
                    <h4 class="my-2 text-md font-semibold p-2 text-center uppercase border-b-2 border-b-white dark:text-gray-300">{{ $lesson->field->subject->name }} - {{ $lesson->name }}</h4>
                    <a href="{{ route('students.report', [$student->id, $lesson->id]) }}" class="group flex flex-col items-center justify-center space-y-2 py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 group-hover:text-green-700 dark:text-gray-300 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span class="dark:text-gray-300 group-hover:text-green-700 transition-all">{{ __('Pogledaj izveštaj') }}</span>
                    </a>
                </div>
                @empty
                <p class="col-span-4 p-8 mt-4 text-center text-md sm:text-lg font-semibold dark:text-gray-300">{{ __('Nema podataka') }}</p>
                @endforelse
            </div>

        </div>

    </div>

</x-app-layout>
