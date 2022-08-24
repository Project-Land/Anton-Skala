<x-app-layout>

    <x-slot name="title">| {{ __('Kreiranje učeničkog naloga') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('Kreiranje učeničkog naloga') }}</h2>
        </div>

        <div class="relative w-full sm:w-1/2 overflow-x-auto shadow-md sm:rounded-lg">

            <form class="p-4" method="POST" action="{{ route('students.store') }}">
                @csrf
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Ime i prezime') }}</label>
                    <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                    @error('name')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Korisničko ime') }}</label>
                    <input type="text" id="username" name="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                    @error('username')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Lozinka') }}</label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                    @error('password')
                    <span class="mt-2 text-xs italic text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                    <p class="mt-2 text-xs italic font-medium text-gray-500 dark:text-gray-400">* {{ __('Lozinka mora sadržati najmanje 8 karaktera') }}</p>
                </div>
                <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">{{ __('Kreiraj') }}</button>
            </form>

        </div>

    </div>

</x-app-layout>
