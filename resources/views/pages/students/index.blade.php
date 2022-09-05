<x-app-layout>

    <x-slot name="title">| {{ __('Učenički nalozi') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('Učenički nalozi') }}</h2>
            <div class="mb-2 md:my-6">
                <a href="{{ route('students.create') }}" class="flex items-center justify-between w-full px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    {{ __('Kreiraj novi učenički nalog') }}
                    <span class="ml-2" aria-hidden="true">+</span>
                </a>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between sm:items-center mb-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
            <form class="" method="GET">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="search">{{ __('Pretraga') }}</label>
                <div class="inline-flex">
                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" type="text" name="search" id="search"
                        placeholder="{{ __('Unesite pojam....') }}" value="{{ request()->search }}">
                    <button type="submit" class="text-white bg-purple-600 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-r-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">{{ __('Traži') }}</button>
                </div>
            </form>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="students" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                    <tr>
                        <th scope="col" class="px-6 py-3">{{ __('Ime i prezime') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Škola') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Izveštaj') }}</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $student->name }}</th>
                        <td class="px-6 py-4">{{ $student->school->name ?? "/" }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('students.show', $student) }}" class="hover:text-green-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </a>
                        </td>
                        <td class="w-full px-6 py-4 text-right inline-flex justify-end space-x-4">
                            <a href="{{ route('students.edit', $student) }}" class="font-medium text-blue-500 dark:text-blue-300 hover:underline">{{ __('Izmeni') }}</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" id="deleteStudent-{{ $student->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="font-medium text-red-500 dark:text-red-300 hover:underline" onclick="deleteStudent({{ $student->id }})">{{ __('Obriši') }}</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th colspan="4" scope="row" class="px-6 py-4 text-center font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ __('Nema podataka') }}</th>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-5">
                {{ $students->withQueryString()->links() }}
            </div>
        </div>

    </div>

    @push('scripts')
    <link rel="stylesheet" href="{{ asset('css/tingle.css') }}">
    <script src="{{ asset('js/tingle.min.js') }}"></script>

    <script>
        function deleteStudent(id){
            var modal = new tingle.modal({
                footer: true,
                stickyFooter: false,
                closeMethods: ['overlay', 'button', 'escape'],
                closeLabel: "{{ __('Zatvori') }}",
                cssClass: ['custom-class-1', 'custom-class-2'],
                onOpen: function() {
                    modal.setContent(`
                        <div class="flex flex-col items-center space-y-4">
                            <h3 class="text-lg font-semibold">{{ __('Brisanje učeničkog naloga') }}</h3>
                            <p>{{ __('Da li ste sigurni?') }}</p>
                        </div>
                    `);

                    modal.addFooterBtn('{{ __("Odustani") }}', 'bg-gray-500 text-white mx-3 w-full px-5 py-3 text-sm font-medium leading-5 transition-colors duration-150 border border-gray-300 rounded-lg sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray', function() {
                        modal.destroy();
                    });
                    modal.addFooterBtn('{{ __("Obriši") }}', 'mx-3 w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-700 hover:bg-red-700 focus:outline-none focus:shadow-outline-red', function() {
                        document.getElementById('deleteStudent-' + id).submit();
                        modal.close();
                    });
                },
            });

            modal.open()
        }
    </script>
    @endpush

</x-app-layout>
