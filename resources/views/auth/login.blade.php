<x-guest-layout>
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="flex flex-col overflow-y-auto md:flex-row">
            <div class="h-32 md:h-auto md:w-1/2">
                <img aria-hidden="true" class="object-cover w-full h-full dark:hidden" src="{{ asset('images/login.jpeg') }}" alt="School" />
                <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block" src="{{ asset('images/login.jpeg') }}" alt="School" />
            </div>
            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <div class="w-full">
                    <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">{{ __('Prijava') }}</h1>
                    <!-- Session Status -->
                    <x-auth-session-status class="my-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <label class="block text-sm">
                            <span class="text-gray-700 dark:text-gray-400">{{ __('Email') }}</span>
                            <input id="email" class="block w-full mt-1 text-sm appearance-none border border-gray-200 dark:border-gray-600 dark:bg-gray-700 rounded py-2 px-3 text-gray-700 mb-3 leading-tight focus:border-purple-400 focus:outline-none focus:shadow-outline-gray dark:text-gray-300 dark:focus:shadow-outline-gray" type="email" name="email"
                                value="{{ old('email') }}" required autofocus />
                        </label>

                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">{{ __('Lozinka') }}</span>
                            <input id="password" class="block w-full mt-1 text-sm appearance-none border border-gray-200 dark:border-gray-600 dark:bg-gray-700 rounded py-2 px-3 text-gray-700 mb-3 leading-tight focus:border-purple-400 focus:outline-none focus:shadow-outline-gray dark:text-gray-300 dark:focus:shadow-outline-gray" type="password"
                                name="password" required autocomplete="current-password" />
                        </label>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 focus:ring-opacity-50" name="remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Zapamti me') }}</span>
                            </label>
                        </div>

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="my-4" :errors="$errors" />

                        <button type="submit" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            {{ __('Prijava') }}
                        </button>
                    </form>

                    <hr class="my-8" />

                    <p class="mt-4">
                        @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Zaboravljena lozinka?') }}
                        </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
