<x-app-layout>

    <x-slot name="title">| {{ __('Statistika učenika') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $student->name }} - {{ __('Statistika') }}</h2>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        </div>

    </div>

</x-app-layout>
