<x-app-layout>

    <x-slot name="title">| {{ __('Izmena nastavničkog naloga') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl text-gray-700 dark:text-gray-200"><span class="font-semibold">{{ $teacher->name }}</span> - {{ __('Izmena nastavničkog naloga') }}</h2>
            <div class="mb-2 md:my-6">
                <a href="{{ route('teachers.index') }}" class="flex items-center justify-between w-full px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                    {{ __('Nazad') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="relative w-1/2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 mb-4">

            <form class="p-4 w-full" method="POST" action="{{ route('teachers.update', $teacher) }}">
                @csrf
                @method('PUT')

                <span class="text-md text-gray-700 dark:text-gray-300 font-medium">{{ __('Osnovne informacije') }}</span>

                <div class="my-6">
                    <label for="school" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Škola') }}</label>
                    <select name="school" id="school" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                        <option value="">{{ __('Izaberi') }}...</option>
                        @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ $teacher->school_id == $school->id ? "selected":"" }}>{{ $school->name }}</option>
                        @endforeach
                    </select>
                    @error('school')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Ime i prezime') }}</label>
                    <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                        value="{{ $teacher->name }}" required>
                    @error('name')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Korisničko ime') }}</label>
                    <input type="text" id="username" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                        value="{{ $teacher->username }}" required>
                    @error('username')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Email adresa') }}</label>
                    <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                        value="{{ $teacher->email }}" required>
                    @error('email')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="lang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Jezik') }}</label>
                    <select name="lang" id="lang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                        <option value="">{{ __('Izaberi') }}...</option>
                        <option value="sr_lat" {{ $teacher->lang == 'sr_lat' ? "selected" :"" }}>{{ __('Srpski (Latinica)') }}</option>
                        <option value="sr_cir" {{ $teacher->lang == 'sr_cir' ? "selected" :"" }}>{{ __('Srpski (Ćirilica)') }}</option>
                        <option value="cro" {{ $teacher->lang == 'cro' ? "selected" :"" }}>{{ __('Hrvatski') }}</option>
                        <option value="slo" {{ $teacher->lang == 'slo' ? "selected" :"" }}>{{ __('Slovenački') }}</option>
                    </select>
                    @error('lang')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <hr class="mb-4">

                <span class="text-md text-gray-700 dark:text-gray-300 font-medium">{{ __('Promena lozinke') }}</span>

                <div class="my-6">
                    <label for="old_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Trenutna lozinka') }}</label>
                    <input type="password" id="old_password" name="old_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                    @error('old_password')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Nova lozinka') }}</label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                    @error('password')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                    <p class="mt-2 text-xs italic font-medium text-gray-500 dark:text-gray-400">* {{ __('Lozinka mora sadržati najmanje 8 karaktera') }}</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">{{ __('Sačuvaj') }}</button>
                </div>
            </form>

        </div>

    </div>

</x-app-layout>
