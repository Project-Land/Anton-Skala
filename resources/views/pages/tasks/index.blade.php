<x-app-layout>

    <x-slot name="title">| {{ __('Zadaci') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('Zadaci') }}</h2>
            <div class="mb-2 md:my-6">
                <a href="{{ route('tasks.create', ['lesson_id' => $lesson_id]) }}"
                    class="flex items-center justify-between w-full px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                    {{ __('Dodaj novi slajd') }}
                    <span class="ml-2" aria-hidden="true">+</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto relative text-center">

        </div>
    </div>

</x-app-layout>
