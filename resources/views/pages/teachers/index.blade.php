<x-app-layout>

    <x-slot name="title">| {{ __('Nastavnički nalozi') }}</x-slot>

    <div class="container px-6 mx-auto grid">

        @include('components.alert')

        <div class="flex flex-col md:flex-row justify-between items-center mb-2">
            <h2 class="my-3 md:my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ __('Nastavnički nalozi') }}</h2>
            <div class="mb-2 md:my-6">
                <a href="{{ route('teachers.create') }}" class="flex items-center justify-between w-full px-2 md:px-4 py-1 md:py-2 text-xs md:text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    {{ __('Kreiraj novi nastavnički nalog') }}
                    <span class="ml-2" aria-hidden="true">+</span>
                </a>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
                    <tr>
                        <th scope="col" class="px-6 py-3">{{ __('Ime i prezime') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Email adresa') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Škola') }}</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $teacher->name }}</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $teacher->email }}</th>
                        <td class="px-6 py-4">{{ $teacher->school->name ?? "/" }}</td>
                        <td class="w-full px-6 py-4 text-right inline-flex justify-end space-x-4">
                            <a href="{{ route('teachers.edit', $teacher) }}" class="font-medium text-blue-500 dark:text-blue-300 hover:underline">{{ __('Izmeni') }}</a>
                            <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" id="deleteTeacher-{{ $teacher->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="font-medium text-red-500 dark:text-red-300 hover:underline" onclick="deleteTeacher({{ $teacher->id }})">{{ __('Obriši') }}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @push('scripts')
    <link rel="stylesheet" href="{{ asset('css/tingle.css') }}">
    <script src="{{ asset('js/tingle.min.js') }}"></script>

    <script>
        function deleteTeacher(id){
            var modal = new tingle.modal({
                footer: true,
                stickyFooter: false,
                closeMethods: ['overlay', 'button', 'escape'],
                closeLabel: "{{ __('Zatvori') }}",
                cssClass: ['custom-class-1', 'custom-class-2'],
                onOpen: function() {
                    modal.setContent(`
                        <div class="flex flex-col items-center space-y-4">
                            <h3 class="text-lg font-semibold">{{ __('Brisanje nastavničkog naloga') }}</h3>
                            <p>{{ __('Da li ste sigurni?') }}</p>
                        </div>
                    `);

                    modal.addFooterBtn('{{ __("Odustani") }}', 'bg-gray-500 text-white mx-3 w-full px-5 py-3 text-sm font-medium leading-5 transition-colors duration-150 border border-gray-300 rounded-lg sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray', function() {
                        modal.destroy();
                    });
                    modal.addFooterBtn('{{ __("Obriši") }}', 'mx-3 w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-700 hover:bg-red-700 focus:outline-none focus:shadow-outline-red', function() {
                        document.getElementById('deleteTeacher-' + id).submit();
                        modal.close();
                    });
                },
            });

            modal.open()
        }
    </script>
    @endpush

</x-app-layout>
