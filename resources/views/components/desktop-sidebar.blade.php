<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">

    <div class="py-4 text-gray-500 dark:text-gray-400">

        <a href="{{ route('dashboard') }}"><img src="{{ asset('images/logo.png') }}" alt="School" class="w-4/5 rounded-full m-auto mb-5"></a>

        <ul class="mt-6">
            <li class="relative px-6 py-3">
                @if(request()->is('/'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('/')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200 dark:text-gray-100" href="{{ route('dashboard') }}">
                    <svg class="w-6 h-6 text-purple-600" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
        </ul>

        <ul>
            <li class="relative px-6 py-3">
                @if(request()->is('items'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('items')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                    </svg>
                    <span class="ml-4">{{ __('Pojmovi') }}</span>
                </a>
            </li>

            <li class="relative px-6 py-3">
                @if(request()->is('subjects'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('subjects')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    <span class="ml-4">{{ __('Predmeti') }}</span>
                </a>
            </li>

            <li class="relative px-6 py-3">
                @if(request()->is('lessons'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('lessons')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    <span class="ml-4">{{ __('Lekcije') }}</span>
                </a>
            </li>

            <li class="relative px-6 py-3">
                @if(request()->is('tasks'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('tasks')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-4">{{ __('Zadaci') }}</span>
                </a>
            </li>


            {{-- <li class="relative px-6 py-3">
                @if(request()->is('tickets'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('tickets')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="">
                    <svg class="w-5 h-5 text-purple-600" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="ml-4">{{ __('Тикети') }}</span>
                </a>
            </li>

            @can('viewAny', App\Models\News::class)
            <li class="relative px-6 py-3">
                @if(request()->is('news'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('news')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('news.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                    <span class="ml-4">{{ __('Обавештења') }}</span>
                </a>
            </li>
            @endcan

            @can('viewAny', App\Models\Survey::class)
            <li class="relative px-6 py-3">
                @if(request()->is('surveys'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('surveys')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('surveys.index') }}">
                    <svg class="w-5 h-5 text-purple-600" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span class="ml-4">{{ __('Упитници') }}</span>
                </a>
            </li>
            @endcan

            @can('viewAny', App\Models\User::class)
            <li class="relative px-6 py-3">
                @if(request()->is('users'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('users')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('users.index') }}">
                    <svg class="w-5 h-5 text-purple-600" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                    <span class="ml-4">{{ __('Кориснички налози') }}</span>
                </a>
            </li>
            @endcan

            @can('viewAny', App\Models\Analytics::class)
            <li class="relative px-6 py-3">
                @if(request()->is('analytics'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('analytics')? " text-purple-800":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('analytics.index') }}">
                    <svg class="w-5 h-5 text-purple-600" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <span class="ml-4">Извештаји о раду</span>
                </a>
            </li>
            @endcan

            @can('viewAny', App\Models\Category::class)
            <li class="relative px-6 py-3" @if(request()->is('categories') || request()->is('subcategories')) x-data="{ isPagesMenuOpen: true}" @endif>
                @if(request()->is('categories') || request()->is('subcategories'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <button class="{{ request()->is('categories') || request()->is('subcategories')? " text-purple-800":"" }} inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" @click="togglePagesMenu" aria-haspopup="true">
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5 text-purple-600" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                            </path>
                        </svg>
                        <span class="ml-4">Шифарник</span>
                    </span>
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <template x-if="isPagesMenuOpen">
                    <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
                        <li class="{{ request()->is('categories')? " text-purple-800":"" }} px-2 py-1 transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200">
                            <a class="w-full" href="{{ route('categories.index') }}">Категорије</a>
                        </li>
                        <li class="{{ request()->is('subcategories')? " text-purple-800":"" }} px-2 py-1 transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200">
                            <a class="w-full" href="{{ route('subcategories.index') }}">
                                Подкатегорије
                            </a>
                        </li>
                    </ul>
                </template>
            </li>
            @endcan --}}
        </ul>
    </div>
</aside>
