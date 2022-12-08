<x-app-layout>

    <x-slot name="title">| {{ __('Izveštaj') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-xl font-semibold text-gray-700 dark:text-gray-200">{{ $student->name }} - {{ $tasks->first()->lesson->name }} - {{ __('Izveštaj') }}</h2>
            <div class="mb-2 md:my-6">
                <a href="{{ route('students.show', $student->id) }}"
                    class="flex items-center justify-between w-full px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                    {{ __('Nazad') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="relative overflow-x-auto sm:rounded-lg">

            <div class="grid grid-rows sm:grid-cols-1 gap-4">
                <table class="rounded-lg bg-gray-200 dark:bg-gray-800 w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-center text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-2">{{ __('Redni broj') }}</th>
                            <th scope="col" class="py-2">{{ __('Zadatak') }}</th>
                            <th scope="col" class="py-2">{{ __('Vreme') }}</th>
                            <th scope="col" class="py-2">{{ __('Broj pokušaja') }}</th>
                            <th scope="col" class="py-2">{{ __('Datum') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr class="text-xs text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $task->display_order }}</td>
                            <td class="px-6 py-4">{{ $task->description }}</td>
                            <td class="px-6 py-4">{{ $task->pivot->elapsed_time }}</td>
                            <td class="px-6 py-4">{{ $task->pivot->no_of_attempts ?? "/" }}</td>
                            <td class="px-6 py-4">{{ $task->pivot->created_at->format('d.m.Y.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-5">
                    {{ $tasks->links() }}
                </div>
            </div>

        </div>

    </div>

</x-app-layout>
