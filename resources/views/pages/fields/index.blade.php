<x-app-layout>

    <x-slot name="title">| {{ $subject_name }} - {{ __('Oblasti') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $subject_name }} - {{ __('Oblasti') }}</h2>
            <div class="mb-2 md:my-6">
                <a href="{{ route('fields.create', ['subject_id' => request()->subject_id]) }}"
                    class="flex items-center justify-between w-full px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                    {{ __('Dodaj novu oblast') }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 ml-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav class="flex px-5 py-3 mb-8 text-gray-700 border border-gray-200 rounded-lg bg-white dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs sm:text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 sm:w-4 h-3 sm:h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        {{ __('Po??etna') }}
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-5 sm:w-6 h-5 sm:h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('subjects.index') }}" class="ml-1 text-xs sm:text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ __('Predmeti') }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-5 sm:w-6 h-5 sm:h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-xs sm:text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $subject_name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="overflow-x-auto relative grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-8 text-center">
            @foreach($fields as $field)
            <a href="{{ route('lessons.index', ['field_id' => $field]) }}" class="block p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="text-lg sm:text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ __($field->name) }}</h5>
            </a>
            @endforeach
        </div>
    </div>

</x-app-layout>
