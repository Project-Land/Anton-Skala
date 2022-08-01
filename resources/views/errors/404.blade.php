<x-guest-layout>
    <div class="container flex flex-col items-center px-6 mx-auto mt-24">
        <svg class="w-14 h-14 mt-8 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd">
            </path>
        </svg>
        <h1 class="text-6xl mt-4 font-semibold text-gray-700 dark:text-gray-200">
            404
        </h1>
        <p class="text-gray-700 text-xl dark:text-gray-300 my-4">
            Страница не постоји
        </p>
        <a class="text-purple-600 hover:underline dark:text-purple-300" href="{{ route('dashboard') }}">
            Назад на почетну
        </a>
    </div>
</x-guest-layout>