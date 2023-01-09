<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">

    <div class="py-4 text-gray-500 dark:text-gray-400">

        <a href="{{ route('dashboard') }}"><img src="{{ asset('images/logo.png') }}" alt="GA-TE" class="w-1/2 rounded-full m-auto mb-5"></a>

        <ul class="mt-6">
            <li class="relative px-6 py-3 {{ request()->is('/') ? 'bg-purple-50 dark:bg-gray-700':'' }}">
                @if(request()->is('/'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 dark:text-purple-400 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('/')? " text-purple-800 dark:text-purple-400":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('dashboard') }}">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="ml-4 mt-1">{{ __('Početna') }}</span>
                </a>
            </li>
        </ul>

        <ul>
            <li class="relative px-6 py-3 {{ request()->is(['subjects', 'lessons', 'fields', 'tasks*', 'create-task']) ? 'bg-purple-50 dark:bg-gray-700':'' }}">
                @if(request()->is(['subjects', 'lessons', 'fields', 'tasks*', 'create-task']))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is(['subjects', 'lessons', 'fields', 'tasks*', 'create-task'])? " text-purple-800 dark:text-purple-400":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('subjects.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                    <span class="ml-4 mt-1">{{ __('Predmeti') }}</span>
                </a>
            </li>

            @if(in_array(Auth::user()->role_id, [App\Models\Role::ADMIN, App\Models\Role::TEACHER]))
            <li class="relative px-6 py-3 {{ request()->is('students*') ? 'bg-purple-50 dark:bg-gray-700':'' }}">
                @if(request()->is('students*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('students*')? " text-purple-800 dark:text-purple-400":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('students.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    <span class="ml-4 mt-1">{{ __('Učenici') }}</span>
                </a>
            </li>
            @endif

            @if(in_array(Auth::user()->role_id, [App\Models\Role::ADMIN]))
            <li class="relative px-6 py-3 {{ request()->is('teachers*') ? 'bg-purple-50 dark:bg-gray-700':'' }}">
                @if(request()->is('teachers*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('teachers*')? " text-purple-800 dark:text-purple-400":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('teachers.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span class="ml-4 mt-1">{{ __('Nastavnici') }}</span>
                </a>
            </li>

            <li class="relative px-6 py-3 {{ request()->is('schools*') ? 'bg-purple-50 dark:bg-gray-700':'' }}">
                @if(request()->is('schools*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                @endif
                <a class="{{ request()->is('schools*')? " text-purple-800 dark:text-purple-400":"" }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-purple-800 dark:hover:text-gray-200" href="{{ route('schools.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-purple-600 dark:text-purple-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                    <span class="ml-4 mt-1">{{ __('Škole') }}</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>
