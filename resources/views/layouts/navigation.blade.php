<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @foreach(config('menu') as $menu)
                    @if(isset($menu['children']))
                    <div x-data="{ open: false }" class="inline-flex items-center {{ request()->routeIs($menu['routePrefix'].'*') ? "border-b-2 border-indigo-400" : ''}}">

                        <div class="relative" style="height: 100%">
                            <!-- Trigger -->
                            <button 
                                @click="open = !open"
                                @click.outside="open = false"
                                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700"
                                style="height: 100%"
                            >
                                {{ __($menu['label']) }}
    
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z"/>
                                </svg>
                            </button>
    
                            <!-- Dropdown -->
                            <div 
                                x-show="open"
                                x-transition
                                class="absolute left-0 w-48 bg-white border rounded-md shadow-lg z-50"
                            >
                                @foreach($menu['children'] as $children)
                                    <a 
                                        href="{{ route($children['route']) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100
                                        {{ request()->routeIs($children['routePrefix'].'*') ? 'bg-gray-100 font-semibold' : '' }}"
                                    >
                                        {{ __($children['label']) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
    
                    </div>
                    @else
                    <x-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['routePrefix'].'*')">
                        {{ __($menu['label']) }}
                    </x-nav-link>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @foreach(config('menu') as $menu)
                @if(isset($menu['children']))
                    <div x-data="{ openSub: false }" class="{{ request()->routeIs($menu['routePrefix'].'*') ? 'block w-full border-l-4 border-indigo-400 text-start text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out' : ''}}">

                        <!-- Parent -->
                        <button 
                            @click="openSub = !openSub"
                            class="w-full flex justify-between items-center px-4 py-2 text-left text-gray-700"
                        >
                            {{ __($menu['label']) }}
                            <span x-text="openSub ? '-' : '+'"></span>
                        </button>

                        <!-- Children -->
                        <div x-show="openSub" x-transition class="pl-4">
                            @foreach($menu['children'] as $child)
                                <x-responsive-nav-link 
                                    :href="route($child['route'])"
                                >
                                    {{ __($child['label']) }}
                                </x-responsive-nav-link>
                            @endforeach
                        </div>

                    </div>
                @else
                    <x-responsive-nav-link 
                        :href="route($menu['route'])" 
                        :active="request()->routeIs($menu['routePrefix'].'*')"
                    >
                        {{ __($menu['label']) }}
                    </x-responsive-nav-link>
                @endif

            @endforeach
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
