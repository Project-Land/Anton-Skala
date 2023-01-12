<x-app-layout>

    <x-slot name="title">| {{ __('Kreiranje zadatka') }}</x-slot>

    <div class="container px-6 lg:px-32 mb-8 mx-auto grid">

        @include('components.alert')

        <div class="flex items-center justify-between">
            <h2 class="my-6 text-lg md:text-xl font-semibold text-gray-700 dark:text-gray-200">
                {{ __('Poveži linijama') }} - {{ __('Kreiranje') }}
            </h2>
            <a href="{{ route('tasks.create', ['lesson_id' => request()->lesson_id]) }}" class="inline-flex items-center p-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                <span>{{ __('Nazad') }}</span>
            </a>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800" x-data="{ show: false }">
            <form action="{{ route('tasks.store-connect-lines-type') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="lesson_id" value="{{ request()->lesson_id }}">
                <input type="hidden" name="type" value="{{ request()->type }}">

                <div class="mb-6">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Tekstualni opis zadatka') }}</label>
                    <input type="text" name="description" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                        value="{{ old('description') }}" required>
                    @error('description')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Ponuđeni odgovori -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Ponuđeni odgovori') }}</label>

                    <div class="grid grid-rows-1 gap-8 border rounded-lg p-4">

                        <template id="template">
                            <div class="border-2 border-violet-300 rounded-lg p-4 grid grid-rows sm:grid-cols gap-6">
                                <div class="border border-violet-300 rounded-lg p-4 grid-rows sm:grid grid-cols-12 gap-6" x-data="imageViewer()">
                                    <div class="col-span-3">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tekst') }}</label>
                                        <input type="text" name="question_text[]" id=""
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                    </div>
                                    <div class="inline-flex sm:border-l-2 sm:border-r-2 py-6 sm:py-0 sm:px-6 col-span-4">
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Slika') }}</label>
                                            <label class="block">
                                                <input type="file" name="question_image[]" value="ss" class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-violet-50 file:text-violet-700
                                            hover:file:bg-violet-100
                                            " accept="image/*" @change="fileChosen" />
                                            </label>
                                        </div>
                                        <template x-if="imageUrl">
                                            <div class="shrink-0">
                                                <img class="h-16 w-16 object-cover rounded-sm" :src="imageUrl" alt="Current profile photo" />
                                            </div>
                                        </template>
                                    </div>
                                    <div class="sm:border-r-2 col-span-4">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Audio zapis') }}</label>
                                        <label class="block">
                                            <input type="file" name="question_audio[]" accept="audio/*" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100
                                        " />
                                        </label>
                                    </div>

                                    <span onclick="this.parentElement.parentElement.remove(); removeAnswer();" class="col-span-1 pt-6 pl-8 cursor-pointer dark:text-gray-300 hover:text-red-500 hover:dark:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="border border-violet-300 rounded-lg p-4 grid-rows sm:grid grid-cols-12 gap-6" x-data="imageViewer()">
                                    <div class="col-span-3">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tekst') }}</label>
                                        <input type="text" name="answer_text[]" id=""
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                    </div>
                                    <div class="inline-flex sm:border-l-2 sm:border-r-2 py-6 sm:py-0 sm:px-6 col-span-4">
                                        <div>
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Slika') }}</label>
                                            <label class="block">
                                                <input type="file" name="answer_image[]" value="ss" class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-violet-50 file:text-violet-700
                                            hover:file:bg-violet-100
                                            " accept="image/*" @change="fileChosen" />
                                            </label>
                                        </div>
                                        <template x-if="imageUrl">
                                            <div class="shrink-0">
                                                <img class="h-16 w-16 object-cover rounded-sm" :src="imageUrl" alt="Current profile photo" />
                                            </div>
                                        </template>
                                    </div>
                                    <div class="sm:border-r-2 col-span-4">
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Audio zapis') }}</label>
                                        <label class="block">
                                            <input type="file" name="answer_audio[]" accept="audio/*" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100
                                        " />
                                        </label>
                                    </div>

                                    <span onclick="this.parentElement.parentElement.remove(); removeAnswer();" class="col-span-1 pt-6 pl-8 cursor-pointer dark:text-gray-300 hover:text-red-500 hover:dark:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </template>

                        <!-- One block -->
                        <div class="border-2 border-violet-300 rounded-lg p-4 grid gap-6">
                            <div class="border border-violet-300 rounded-lg p-4 grid grid-rows sm:grid-cols-12 gap-6" x-data="imageViewer()">
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tekst') }}</label>
                                    <input type="text" name="question_text[]" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                </div>
                                <div class="inline-flex sm:border-l-2 sm:border-r-2 py-6 sm:py-0 sm:px-6 col-span-5">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Slika') }}</label>
                                        <label class="block">
                                            <input type="file" name="question_image[]" value="" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100
                                        " accept="image/*" @change="fileChosen" />
                                        </label>
                                    </div>
                                    <template x-if="imageUrl">
                                        <div class="shrink-0">
                                            <img class="h-16 w-16 object-cover rounded-sm" :src="imageUrl" alt="Current profile photo" />
                                        </div>
                                    </template>
                                </div>
                                <div class="sm:border-r-2 col-span-4">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Audio zapis') }}</label>
                                    <label class="block">
                                        <input type="file" name="question_audio[]" accept="audio/*" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                    " />
                                    </label>
                                </div>

                            </div>

                            <!-- One block -->
                            <div class="border border-violet-300 rounded-lg p-4 grid grid-rows sm:grid-cols-12 gap-6" x-data="imageViewer()">
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tekst') }}</label>
                                    <input type="text" name="answer_text[]" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                </div>
                                <div class="inline-flex sm:border-l-2 sm:border-r-2 py-6 sm:py-0 sm:px-6 col-span-5">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Slika') }}</label>
                                        <label class="block">
                                            <input type="file" name="answer_image[]" value="" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100
                                        " accept="image/*" @change="fileChosen" />
                                        </label>
                                    </div>
                                    <template x-if="imageUrl">
                                        <div class="shrink-0">
                                            <img class="h-16 w-16 object-cover rounded-sm" :src="imageUrl" alt="Current profile photo" />
                                        </div>
                                    </template>
                                </div>
                                <div class="sm:border-r-2 col-span-4">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Audio zapis') }}</label>
                                    <label class="block">
                                        <input type="file" name="answer_audio" accept="audio/*" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                    " />
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div id="newAnswers" class="grid gap-8">

                        </div>

                        <div class="flex justify-center">
                            <span class="inline-flex mt-2 items-center px-2 py-2 bg-gray-700 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:shadow-outline-gray cursor-pointer transition-all" onclick="addAnswer()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="color_border" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Dodaj pojmovima okvir u boji') }}</label>
                    <input id="color_border" name="color_border" type="checkbox" value="1" class="w-4 h-4 text-purple-600 bg-gray-100 rounded border-gray-300 focus:ring-purple-600 dark:focus:ring-purple-700 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </div>

                <div class="flex justify-between items-center">
                    <div class="mt-4">
                        <button type="button" class="text-gray-900 cursor-pointer bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-lg text-sm px-2 py-2 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            @click="show = !show">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                        </button>
                    </div>
                    <button type="submit" class="w-1/2 sm:w-1/5 mt-4 px-8 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">{{ __('Kreiraj') }}</button>
                </div>
                <div class="flex" x-show="show">
                    <img class="w-full sm:w-1/3 p-4 border border-gray-500 rounded-lg mt-2" src="/images/connect_lines.png" alt="poveži_linijama">
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        sessionStorage.setItem('number_of_answers', 1);

        function addAnswer()
        {
            let number_of_answers = sessionStorage.getItem('number_of_answers')
            if(number_of_answers < 3) {
                number_of_answers++
                sessionStorage.setItem('number_of_answers', number_of_answers)
                let content = document.getElementById('template').innerHTML;
                document.getElementById('newAnswers').insertAdjacentHTML('beforeend', content);
            } else {
                alert("{{ __('Nije moguće dodati više odgovora') }}")
                return
            }
        }

        function removeAnswer()
        {
            let number_of_answers = sessionStorage.getItem('number_of_answers')
            number_of_answers--
            sessionStorage.setItem('number_of_answers', number_of_answers)
        }

        function imageViewer() {
            return {
                imageUrl: '',

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },

                fileToDataUrl(event, callback) {
                    if (! event.target.files.length) return

                    let file = event.target.files[0],
                        reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = e => callback(e.target.result)
                },
            }
        }
    </script>
    @endpush

</x-app-layout>
