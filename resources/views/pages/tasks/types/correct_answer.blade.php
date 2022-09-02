<x-app-layout>

    <x-slot name="title">| {{ __('Zadatak') }}</x-slot>

    <div class="container px-6 lg:px-32 mx-auto grid">

        @include('components.alert')

        <div class="flex items-center justify-between">
            <h2 class="my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ __('Zadatak') }}
            </h2>
            <a href="{{ route('tasks.create', ['lesson_id' => request()->lesson_id]) }}" class="inline-flex items-center p-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                <span>{{ __('Nazad') }}</span>
            </a>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('tasks.store-correct-answer-type') }}" method="POST" enctype="multipart/form-data">
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

                <!-- Pitanje -->
                <div class="mb-6" x-data="imageViewer()">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Pitanje') }}</label>
                    <div class="border border-purple-600 rounded-lg p-4 grid grid-cols-3 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tekst') }}</label>
                            <input type="text" name="question_text" id="" value="{{ old('question_text') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                        </div>

                        <div class="inline-flex border-l-2 border-r-2 px-6">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Slika') }}</label>
                                <label class="block">
                                    <input type="file" name="question_image" class="block w-full text-sm text-slate-500
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
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Audio zapis') }}</label>
                            <label class="block">
                                <input type="file" name="question_audio" accept="audio/*" class="block w-full text-sm text-slate-500
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

                <!-- Ponuđeni odgovori -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Ponuđeni odgovori') }}</label>

                    <div class="grid grid-rows-1 gap-8 border rounded-lg p-4">

                        <template id="template">
                            <div class="border border-violet-300 rounded-lg p-4 grid grid-cols-12 gap-6" x-data="imageViewer()">
                                <div class="col-span-3">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tekst') }}</label>
                                    <input type="text" name="answer_text[]" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                </div>
                                <div class="inline-flex border-l-2 border-r-2 px-6 col-span-4">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Slika') }}</label>
                                        <label class="block">
                                            <input type="file" name="answer_image[]" class="block w-full text-sm text-slate-500
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
                                <div class="border-r-2 col-span-3">
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
                                <div class="col-span-1">
                                    <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tačan odgovor?') }}</label>
                                    <select name="answer_correct[]" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                        <option value="0" selected>{{ __('Ne') }}</option>
                                        <option value="1">{{ __('Da') }}</option>
                                    </select>
                                </div>
                                <span onclick="this.parentElement.remove()" class="col-span-1 pt-6 pl-8 cursor-pointer hover:text-red-500 dark:text-gray-300 hover:dark:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>

                        </template>

                        <!-- One block -->

                        <div class="border border-violet-300 rounded-lg p-4 grid grid-cols-12 gap-6" x-data="imageViewer()">
                            <div class="col-span-3">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tekst') }}</label>
                                <input type="text" name="answer_text[]" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            </div>
                            <div class="inline-flex border-l-2 border-r-2 px-6 col-span-5">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Slika') }}</label>
                                    <label class="block">
                                        <input type="file" name="answer_image[]" class="block w-full text-sm text-slate-500
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
                            <div class="border-r-2 col-span-3">
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
                            <div class="col-span-1">
                                <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tačan odgovor?') }}</label>
                                <select name="answer_correct[]" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                    <option value="0" selected>{{ __('Ne') }}</option>
                                    <option value="1">{{ __('Da') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- One block -->
                        <div class="border border-violet-300 rounded-lg p-4 grid grid-cols-12 gap-6" x-data="imageViewer()">
                            <div class="col-span-3">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tekst') }}</label>
                                <input type="text" name="answer_text[]" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            </div>
                            <div class="inline-flex border-l-2 border-r-2 px-6 col-span-5">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Slika') }}</label>
                                    <label class="block">
                                        <input type="file" name="answer_image[]" class="block w-full text-sm text-slate-500
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
                            <div class="border-r-2 col-span-3">
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
                            <div class="col-span-1">
                                <label class="block mb-2 text-xs font-medium text-gray-900 dark:text-gray-300" for="file_input">{{ __('Tačan odgovor?') }}</label>
                                <select name="answer_correct[]" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                    <option value="0" selected>{{ __('Ne') }}</option>
                                    <option value="1">{{ __('Da') }}</option>
                                </select>
                            </div>
                        </div>

                        <div id="newAnswers" class="grid gap-8"></div>

                        <div class="flex justify-center">
                            <span class="inline-flex mt-2 items-center px-2 py-2 bg-gray-700 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:shadow-outline-gray cursor-pointer transition-all" onclick="addAnswer()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-1/2 md:w-1/5 mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">{{ __('Kreiraj') }}
                </button>
            </form>
        </div>
        <div>
            <p class="mb-4 dark:text-gray-300">{{ __('Primer') }}</p>
            <img class="w-full sm:w-1/3" src="/images/correct_answer.png" alt="tacan odgovor">
        </div>
    </div>

    <script>
        function addAnswer()
        {
            let content = document.getElementById('template').innerHTML;
            document.getElementById('newAnswers').insertAdjacentHTML('beforeend', content);
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

</x-app-layout>
