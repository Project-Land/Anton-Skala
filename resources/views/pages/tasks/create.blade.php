<x-app-layout>

    <x-slot name="title">| {{ __('Kreiranje zadatka') }}</x-slot>

    <div class="container px-6 lg:px-32 2xl:px-64 mx-auto grid">
        @include('components.alert')

        <div class="flex items-center justify-between">
            <h2 class="my-6 text-lg md:text-xl font-semibold text-gray-700 dark:text-gray-200">
                {{ __('Kreiranje zadatka') }}
            </h2>
            <a href="{{ route('tasks.index', ['lesson_id' => request()->lesson_id]) }}" class="inline-flex items-center p-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                <span>{{ __('Nazad') }}</span>
            </a>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('tasks.type') }}" method="GET">
                <input type="hidden" name="lesson_id" value="{{ request()->lesson_id }}">

                <div class="mb-6">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Odaberi tip zadatka') }}</label>
                    <select name="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                        <option value="">{{ __('Odaberi...') }}</option>
                        <option value="description">{{ __('Uvod') }}</option>
                        <option value="story">{{ __('Priča') }}</option>
                        <option value="drag_and_drop">{{ __('Prevlačenje') }}</option>
                        <option value="correct_answer">{{ __('Jedan ili više tačnih odgovora') }}</option>
                        <option value="column_sorting">{{ __('Prevlačenje po kolonama (isti pojmovi)') }}</option>
                        <option value="column_sorting_multiple">{{ __('Prevlačenje po kolonama (različiti pojmovi)') }}</option>
                        <option value="add_letter">{{ __('Dodavanje slova u reči') }}</option>
                        <option value="sentence">{{ __('Slaganje rečenice') }}</option>
                        <option value="complete_the_sentence">{{ __('Dopuna rečenice') }}</option>
                        <option value="connect_lines">{{ __('Poveži linijama') }}</option>
                    </select>
                    @error('type')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="inline-flex justify-between items-center w-1/2 md:w-1/5 mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">{{ __('Nastavi') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

</x-app-layout>
