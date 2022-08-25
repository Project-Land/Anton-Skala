<x-app-layout>

    <x-slot name="title">| {{ __('Statistika učenika') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $student->name }} - {{ __('Statistika') }}</h2>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            {{-- <h3 class="my-2 text-xl font-semibold p-2">{{ __('Lekcije') }}</h3> --}}

            <div class="grid grid-rows sm:grid-cols-4 gap-4">
                @foreach($student->lessons as $lesson)
                <div class="rounded-lg bg-gray-200">
                    <h4 class="my-2 text-md font-semibold p-2 text-center uppercase">{{ $lesson->name }}</h4>
                    <table class="text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-center text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                            <tr>
                                <th scope="col" class="py-1">{{ __('Zadatak') }}</th>
                                <th scope="col" class="py-1">{{ __('Vreme') }}</th>
                                <th scope="col" class="py-1">{{ __('Broj pokušaja') }}</th>
                                <th scope="col" class="py-1">{{ __('Datum') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->tasks as $task)
                            <tr class="text-xs bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $task->description }}</td>
                                <td class="px-6 py-4">{{ $task->pivot->elapsed_time }}</td>
                                <td class="px-6 py-4">{{ $task->pivot->no_of_attempts }}</td>
                                <td class="px-6 py-4">{{ $task->pivot->created_at->format('d.m.Y.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>

        </div>

    </div>

</x-app-layout>
