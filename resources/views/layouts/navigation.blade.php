<nav x-data="{ open: false }" class="bg-white dark:bg-gray-100 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        {{-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" /> --}}
                        <img src="/images/X.png" alt="Logo" class="block h-12 w-auto">
                    </a>
                </div>
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                              {{ request()->routeIs('home') ? 'border-indigo-400 text-gray-900 dark:text-gray-100' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                        {{ __('Home') }}
                    </a>
                </div> --}}
            </div>

            {{-- Tabs Desktop --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <nav class="flex items-center gap-1">
                        <a href="{{ route('home') }}"
                           class="px-3 py-2 rounded-md {{ request()->routeIs('home') ? 'bg-white dark:bg-gray-800 shadow-sm' : 'bg-gray-50 dark:bg-gray-900/40 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Home
                        </a>
                        <a href="{{ route('disasters.index') }}"
                           class="px-3 py-2 rounded-md {{ request()->routeIs('disasters.*') ? 'bg-white dark:bg-gray-800 shadow-sm' : 'bg-gray-50 dark:bg-gray-900/40 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Bencana
                        </a>
                         @if(auth()->user()->isAdmin())
        <a href="{{ route('users.index') }}"
           class="px-3 py-2 rounded-md {{ request()->routeIs('users.*') ? 'bg-white dark:bg-gray-800 shadow-sm' : 'bg-gray-50 dark:bg-gray-900/40 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
            Users
        </a>
    @endif
                        @if (Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}"
                               class="px-3 py-2 rounded-md {{ request()->routeIs('profile.edit') ? 'bg-white dark:bg-gray-800 shadow-sm' : 'bg-gray-50 dark:bg-gray-900/40 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                Profile
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-2 rounded-md text-red-700 dark:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30">
                                Log Out
                            </button>
                        </form>
                        <span class="ms-3 text-xs text-gray-500 dark:text-gray-400">
                            masuk sebagai <b>{{ auth()->user()->name }}</b>
                        </span>
                    </nav>
                @endauth

                @guest
                    <nav class="flex items-center gap-1">
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md bg-gray-50 dark:bg-gray-900/40 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">Login</a>
                        {{-- <a href="{{ route('register') }}" class="px-3 py-2 rounded-md bg-gray-50 dark:bg-gray-900/40 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm">Register</a> --}}
                    </nav>
                @endguest
            </div>

            {{-- Hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
                <div class="px-4 mb-2">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('disasters.index')" :active="request()->routeIs('disasters.*')">Bencana</x-responsive-nav-link>
                    @if (Route::has('profile.edit'))
                        <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">Profile</x-responsive-nav-link>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth

            @guest
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">Login</x-responsive-nav-link>
                    {{-- <x-responsive-nav-link :href="route('register')">Register</x-responsive-nav-link> --}}
                </div>
            @endguest
        </div>
    </div>
</nav>
