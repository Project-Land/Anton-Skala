<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-center space-y-8 sm:space-y-0 sm:space-x-32 items-center px-16 py-8">
                    <img class="w-1/2 sm:w-1/5" src="{{ asset('images/project_logo.jpg') }}" alt="project_logo">
                    <img class="w-2/3 sm:w-1/5" src="{{ asset('images/eu_logo.png') }}" alt="eu_logo">
                </div>
                <div class="p-6 bg-white dark:text-gray-300 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-center text-lg sm:text-xl font-medium">GA-TE - {{ __('Good Aplication To Education') }}</h2>
                    <p class="text-sm sm:text-base text-center pt-6">{{ __('Evropski projekat podržan od strane Erasmus + programa koji okuplja 4 partnerske organizacije iz tri različite zemlje.') }}</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
