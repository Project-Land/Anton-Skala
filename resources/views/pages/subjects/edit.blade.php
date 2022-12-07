<x-app-layout>

    <x-slot name="title">| {{ __('Izmena predmeta') }}</x-slot>

    <div class="container px-6 lg:px-32 2xl:px-64 mx-auto grid">
        @include('components.alert')

        <div class="flex items-center justify-between">
            <h2 class="my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $subject->name }} - {{ __('Izmena predmeta') }}
            </h2>
            <a href="{{ route('subjects.index') }}" class="inline-flex items-center p-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                <span>{{ __('Nazad') }}</span>
            </a>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('subjects.update', $subject) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Naslov') }}</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                        value="{{ $subject->name }}" required>
                    @error('name')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                @if(in_array(Auth::user()->lang, ['sr', 'sr_cir', 'sr_lat']))
                <div class="mb-6">
                    <label for="lang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Pismo') }}</label>
                    <select name="lang" id="lang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                        <option value="sr_lat" @selected($subject->lang == 'sr_lat')>{{ __('Latinica') }}</option>
                        <option value="sr_cir" @selected($subject->lang == 'sr_cir')>{{ __('Ćirilica') }}</option>
                    </select>
                    @error('lang')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
                @else
                <input type="hidden" name="lang" value="{{ Auth::user()->lang }}">
                @endif

                <button type="submit" class="w-1/2 md:w-1/5 mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">{{ __('Izmeni') }}</button>
            </form>
        </div>
    </div>

</x-app-layout>
