<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-arsenic-primary leading-tight">
                {{ __('Role Management') }}
            </h2>
            @can('manage_roles')
                <a href="{{ route('roles.create') }}"
                    class="bg-arsenic-primary hover:bg-arsenic-dark text-arsenic-light font-semibold py-2.5 px-6 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out border border-arsenic-primary hover:border-arsenic-dark">
                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                    Tambah Role
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Search and Filter -->
                    <div class="mb-6 flex flex-wrap gap-4">
                        <form method="GET" class="flex gap-4 flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama role..." class="flex-1 rounded-md border-gray-300 shadow-sm">

                            <button type="submit"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>

                            @if (request('search'))
                                <a href="{{ route('roles.index') }}"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Roles Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Deskripsi
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Permissions
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Users
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dibuat
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($roles as $role)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-indigo-700">
                                                            {{ strtoupper(substr($role->display_name ?? $role->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $role->display_name ?? $role->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $role->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $role->description ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @if ($role->permissions && count($role->permissions) > 0)
                                                    @foreach (array_slice($role->permissions, 0, 3) as $permission)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            {{ $permission }}
                                                        </span>
                                                    @endforeach
                                                    @if (count($role->permissions) > 3)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            +{{ count($role->permissions) - 3 }} lagi
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="text-sm text-gray-500">Tidak ada permissions</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $role->users_count ?? 0 }} users
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $role->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('roles.show', $role) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">Lihat</a>

                                                @can('manage_roles')
                                                    <a href="{{ route('roles.edit', $role) }}"
                                                        class="text-yellow-600 hover:text-yellow-900">Edit</a>

                                                    @if (!in_array($role->name, ['admin', 'user']))
                                                        <form method="POST" action="{{ route('roles.destroy', $role) }}"
                                                            class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900"
                                                                onclick="return confirm('Yakin ingin menghapus role ini?')">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada role ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $roles->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
