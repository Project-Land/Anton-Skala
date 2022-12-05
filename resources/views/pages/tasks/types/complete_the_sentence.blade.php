<x-app-layout>

    <x-slot name="title">| {{ __('Kreiranje zadatka') }}</x-slot>

    <div class="container px-6 lg:px-32 mx-auto grid">

        @include('components.alert')

        <div class="flex items-center justify-between">
            <h2 class="my-6 text-lg md:text-xl font-semibold text-gray-700 dark:text-gray-200">
                {{ __('Dopuna rečenice') }} - {{ __('Kreiranje') }}
            </h2>
            <a href="{{ route('tasks.create', ['lesson_id' => request()->lesson_id]) }}" class="inline-flex items-center p-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                <span>{{ __('Nazad') }}</span>
            </a>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('tasks.store-complete-the-sentence-type') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="lesson_id" value="{{ request()->lesson_id }}">
                <input type="hidden" name="type" value="{{ request()->type }}">

                <!-- Slika i opis -->
                <div class="mb-6">
                    <div class="border border-gray-200 rounded-lg p-4 ">
                        <div class="space-y-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="description">{{ __('Tekstualni opis zadatka') }}</label>
                                <input type="text" name="description" value="{{ old('description') }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            </div>

                            <template id="template">
                                <div class="border border-violet-300 rounded-lg p-4 grid grid-cols-6 items-center sentence">
                                    <div class="col-span-5">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="string">{{ __('Rečenica') }} ({{ __('U zagradu staviti traženu reč') }})</label>
                                        <input type="text" name="sentences[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                                            required placeholder="{{ __('Duva (vruć) vetar.') }}">
                                    </div>
                                    <span onclick="this.parentElement.remove()" class="col-span-1 pt-6 pl-8 cursor-pointer dark:text-gray-300 hover:text-red-500 hover:dark:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                            </template>

                            <div class="grid grid-rows sm:grid-cols-2 gap-4" id="newSentence">
                                <div class="border border-violet-300 rounded-lg p-4 sentence">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="string">{{ __('Rečenica') }} ({{ __('U zagradu staviti traženu reč') }})</label>
                                    <input type="text" name="sentences[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" required
                                        placeholder="{{ __('Duva (vruć) vetar.') }}">
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <span class="inline-flex mt-2 items-center px-2 py-2 bg-gray-700 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:shadow-outline-gray cursor-pointer transition-all" onclick="addSentence()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-1/2 md:w-1/5 mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">{{ __('Kreiraj') }}</button>
            </form>
        </div>
        <div>
            <p class="mb-4">{{ __('Primer') }}</p>
            <div class="flex flex-col sm:flex-row space-x-10">
                <img class="w-full sm:w-1/3" src="/images/form_a_sentence1.jpg" alt="formiranje_rečenice">
                <img class="w-full sm:w-1/3" src="/images/form_a_sentence2.jpg" alt="formiranje_rečenice">
            </div>
        </div>
    </div>

    <script>
        function addSentence()
        {
            let totalSentences = document.getElementsByClassName('sentence').length;
            if(totalSentences > 3) {
                alert('{{ __("Nije moguće dodati više od 4 rečenica po zadatku") }}.');
                return;
            }

            let content = document.getElementById('template').innerHTML;
            document.getElementById('newSentence').insertAdjacentHTML('beforeend', content);
        }
    </script>

</x-app-layout>
