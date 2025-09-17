<!-- Top Navigation Bar -->
<nav class="bg-arsenic-light shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side - Kosongkan atau hilangkan bagian title -->
            <div class="flex items-center">
                <!-- Hapus atau kosongkan bagian ini -->
            </div>

            <!-- Right side - Enhanced User Profile -->
            <div class="flex items-center">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2 border border-arsenic-primary/20 text-sm leading-4 font-medium rounded-lg text-arsenic-primary bg-white hover:bg-arsenic-accent hover:text-arsenic-dark hover:border-arsenic-accent focus:outline-none focus:ring-2 focus:ring-arsenic-accent focus:ring-opacity-50 transition-all ease-in-out duration-200 shadow-sm hover:shadow-md">
                            <!-- User Avatar -->
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-arsenic-accent to-arsenic-primary rounded-full flex items-center justify-center mr-3 shadow-sm">
                                <span class="text-arsenic-dark font-semibold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <!-- User Info -->
                            <div class="text-left">
                                <div class="font-medium text-arsenic-primary">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-arsenic-primary/70">{{ Auth::user()->email }}</div>
                            </div>
                            <!-- Dropdown Arrow -->
                            <div class="ml-3">
                                <svg class="fill-current h-4 w-4 text-arsenic-primary/60"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-white border border-arsenic-primary/20 rounded-lg shadow-xl py-2">
                            <!-- User Info Header -->
                            <div class="px-4 py-3 border-b border-arsenic-primary/10">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-arsenic-accent to-arsenic-primary rounded-full flex items-center justify-center mr-3 shadow-sm">
                                        <span class="text-arsenic-dark font-bold">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-arsenic-primary">{{ Auth::user()->name }}</div>
                                        <div class="text-sm text-arsenic-primary/70">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-1">
                                <x-dropdown-link :href="route('profile.edit')"
                                    class="flex items-center px-4 py-2 text-arsenic-primary hover:bg-arsenic-accent/10 hover:text-arsenic-primary transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Divider -->
                                <div class="border-t border-arsenic-primary/10 my-1"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-200"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
