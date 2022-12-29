<x-app-layout>

    <x-slot name="title">| {{ __('Oblasti') }}</x-slot>

    <div class="container px-6 lg:px-32 2xl:px-64 mx-auto grid">
        @include('components.alert')

        <div class="flex items-center justify-between">
            <h2 class="my-6 text-lg md:text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ __('Kreiranje nove oblasti') }}
            </h2>
            <a href="{{ route('fields.index', ['subject_id' => request()->subject_id]) }}" class="inline-flex items-center p-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                <span>{{ __('Nazad') }}</span>
            </a>
        </div>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('fields.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="subject_id" value="{{ request()->subject_id }}">
                <input type="hidden" name="lang" value="{{ Auth::user()->lang }}">
                <div class="mb-6">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Naslov') }}</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" required>
                    @error('name')
                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div x-data="imageViewer()">
                    <div class="mb-6 inline-flex space-x-6 items-end">
                        <div>
                            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Naslovna slika') }}</label>

                            <label class="block">
                                <input type="file" name="image" id="image" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-violet-50 file:text-violet-700
                                hover:file:bg-violet-100 cursor-pointer mb-4
                                " accept="image/*" @change="fileChosen" />
                            </label>

                            @error('image')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <template x-if="imageUrl">
                            <div class="shrink-0">
                                <img class="h-32 w-32 object-cover rounded-sm border" :src="imageUrl" alt="Current profile photo" />
                            </div>
                        </template>

                        <template x-if="imageUrl">
                            <button type="button" @click="clearImage" class="text-white dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-2 text-red-500 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="w-1/2 md:w-1/5 mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 rounded-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-lime">{{ __('Kreiraj') }}</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function imageViewer() {
            return {
                imageUrl: '',

                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src)
                },

                clearImage(event) {
                    this.imageUrl = ''
                    document.getElementById('image').value = ''
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
