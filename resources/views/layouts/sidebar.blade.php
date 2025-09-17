<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-50 bg-arsenic-primary text-arsenic-light transition-all duration-300 ease-in-out"
    :class="{ 'w-64': sidebarOpen, 'w-16': !sidebarOpen }">

    <!-- Logo Section with Toggle Button -->
    <div class="flex flex-col items-center justify-center bg-arsenic-dark"
        :class="{ 'h-24': sidebarOpen, 'h-20': !sidebarOpen }">
        <!-- Hamburger Button -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="p-2 rounded-md text-arsenic-light hover:bg-arsenic-accent hover:text-arsenic-dark focus:outline-none focus:bg-arsenic-accent focus:text-arsenic-dark transition duration-150 ease-in-out"
            :class="{ 'mb-3': sidebarOpen, 'mb-2': !sidebarOpen }">
            <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Logo with added margin -->
        <div x-show="sidebarOpen" class="flex items-center mt-2">
            <x-application-logo class="block h-8 w-auto fill-current text-arsenic-light" />
            <span class="ml-2 text-xl font-semibold text-arsenic-light">{{ config('app.name') }}</span>
        </div>
        <div x-show="!sidebarOpen" class="flex items-center mt-1">
            <x-application-logo class="block h-6 w-auto fill-current text-arsenic-light" />
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-4">
        <div class="space-y-1" :class="{ 'px-4': sidebarOpen, 'px-2': !sidebarOpen }">
            <!-- Dashboard - Kembalikan tulisan Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center text-sm font-medium rounded-lg transition-colors duration-200 group text-arsenic-light {{ request()->routeIs('dashboard') ? 'bg-arsenic-accent text-arsenic-dark' : 'hover:bg-arsenic-dark' }}"
                :class="{
                    'px-4 py-3': sidebarOpen,
                    'px-2 py-2 justify-center': !sidebarOpen
                }">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                <!-- Tooltip for collapsed state -->
                <div x-show="!sidebarOpen"
                    class="absolute left-16 bg-arsenic-dark text-arsenic-light px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                    Dashboard
                </div>
            </a>

            @can('manage_users')
                <!-- User Management -->
                <a href="{{ route('users.index') }}"
                    class="flex items-center text-sm font-medium rounded-lg transition-colors duration-200 group text-arsenic-light {{ request()->routeIs('users.*') ? 'bg-arsenic-accent text-arsenic-dark' : 'hover:bg-arsenic-dark' }}"
                    :class="{
                        'px-4 py-3': sidebarOpen,
                        'px-2 py-2 justify-center': !sidebarOpen
                    }">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">User Management</span>
                    <!-- Tooltip for collapsed state -->
                    <div x-show="!sidebarOpen"
                        class="absolute left-16 bg-arsenic-dark text-arsenic-light px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        User Management
                    </div>
                </a>
            @endcan

            @can('manage_roles')
                <!-- Role Management -->
                <a href="{{ route('roles.index') }}"
                    class="flex items-center text-sm font-medium rounded-lg transition-colors duration-200 group text-arsenic-light {{ request()->routeIs('roles.*') ? 'bg-arsenic-accent text-arsenic-dark' : 'hover:bg-arsenic-dark' }}"
                    :class="{
                        'px-4 py-3': sidebarOpen,
                        'px-2 py-2 justify-center': !sidebarOpen
                    }">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Role Management</span>
                    <!-- Tooltip for collapsed state -->
                    <div x-show="!sidebarOpen"
                        class="absolute left-16 bg-arsenic-dark text-arsenic-light px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        Role Management
                    </div>
                </a>
            @endcan

            @can('view_projects')
                <!-- Project Management -->
                <a href="{{ route('projects.index') }}"
                    class="flex items-center text-sm font-medium rounded-lg transition-colors duration-200 group text-arsenic-light {{ request()->routeIs('projects.*') ? 'bg-arsenic-accent text-arsenic-dark' : 'hover:bg-arsenic-dark' }}"
                    :class="{
                        'px-4 py-3': sidebarOpen,
                        'px-2 py-2 justify-center': !sidebarOpen
                    }">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Project Management</span>
                    <!-- Tooltip for collapsed state -->
                    <div x-show="!sidebarOpen"
                        class="absolute left-16 bg-arsenic-dark text-arsenic-light px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        Project Management
                    </div>
                </a>
            @endcan

            @can('view_finances')
                <!-- Finance Management Dropdown -->
                <div x-data="{ open: {{ request()->routeIs('finances.*') ? 'true' : 'false' }} }"
                    class="text-sm font-medium rounded-lg transition-colors duration-200 group text-arsenic-light"
                    :class="{
                        'px-4 py-3': sidebarOpen,
                        'px-2 py-2 justify-center': !sidebarOpen
                    }">

                    <!-- Main Finance Button -->
                    <button @click="open = !open"
                        class="flex items-center w-full rounded-lg transition-colors duration-200 group text-arsenic-light {{ request()->routeIs('finances.*') ? 'bg-arsenic-accent text-arsenic-dark' : 'hover:bg-arsenic-dark' }}"
                        :class="{
                            'px-0 py-0': sidebarOpen,
                            'px-2 py-2 justify-center': !sidebarOpen
                        }">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3">Finance Management</span>
                        <svg x-show="sidebarOpen" class="w-4 h-4 ml-auto transition-transform duration-200"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>

                        <!-- Tooltip for collapsed state -->
                        <div x-show="!sidebarOpen"
                            class="absolute left-16 bg-arsenic-dark text-arsenic-light px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                            Finance Management
                        </div>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open && sidebarOpen" x-transition class="ml-6 mt-2 space-y-1">
                        <!-- Cashflow -->
                        <a href="{{ route('finances.index') }}"
                            class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors duration-200 text-arsenic-light {{ request()->routeIs('finances.index') ? 'bg-arsenic-accent text-arsenic-dark' : 'hover:bg-arsenic-dark' }}">
                            <svg class="w-4 h-4 flex-shrink-0 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6">
                                </path>
                            </svg>
                            <span>Cashflow</span>
                        </a>

                        <!-- Incomes -->
                        <a href="{{ route('incomes.index') }}"
                            class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors duration-200 text-arsenic-light {{ request()->routeIs('incomes.*') ? 'bg-arsenic-accent text-arsenic-dark' : 'hover:bg-arsenic-dark' }}">
                            <svg class="w-4 h-4 flex-shrink-0 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12">
                                </path>
                            </svg>
                            <span>Incomes</span>
                        </a>

                        <!-- Expenses -->
                        <a href="{{ route('finances.expenses') }}"
                            class="flex items-center px-3 py-2 text-sm rounded-lg transition-colors duration-200 text-arsenic-light {{ request()->routeIs('finances.expenses') ? 'bg-arsenic-accent text-arsenic-dark' : 'hover:bg-arsenic-dark' }}">
                            <svg class="w-4 h-4 flex-shrink-0 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 13l-5 5m0 0l-5-5m5 5V6">
                                </path>
                            </svg>
                            <span>Expenses</span>
                        </a>
                    </div>
                </div>
            @endcan

            @can('view_reports')
                <!-- Reports -->
                <a href="#"
                    class="flex items-center text-sm font-medium rounded-lg transition-colors duration-200 group text-arsenic-light hover:bg-arsenic-dark"
                    :class="{
                        'px-4 py-3': sidebarOpen,
                        'px-2 py-2 justify-center': !sidebarOpen
                    }">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Reports</span>
                    <!-- Tooltip for collapsed state -->
                    <div x-show="!sidebarOpen"
                        class="absolute left-16 bg-arsenic-dark text-arsenic-light px-2 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        Reports
                    </div>
                </a>
            @endcan
        </div>
    </nav>
</div>

<!-- Overlay for mobile -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"
    @click="sidebarOpen = false">
</div>
