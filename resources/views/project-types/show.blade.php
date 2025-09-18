<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Tipe Proyek') }}
            </h2>
            <div class="flex space-x-2">
                @can('edit_project_types')
                    <a href="{{ route('project-types.edit', $projectType) }}" 
                       class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('project-types.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                                Informasi Dasar
                            </h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Tipe Proyek</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $projectType->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $projectType->description ?: 'Tidak ada deskripsi' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $projectType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $projectType->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dibuat</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $projectType->created_at->format('d M Y H:i') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Diupdate</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $projectType->updated_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Project Statistics -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">
                                Statistik Proyek
                            </h3>
                            
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <div>
                                        <p class="text-2xl font-bold text-blue-900">
                                            {{ $projectType->projects()->count() }}
                                        </p>
                                        <p class="text-sm text-blue-700">Total Proyek</p>
                                    </div>
                                </div>
                            </div>

                            @if($projectType->projects()->count() > 0)
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-2xl font-bold text-green-900">
                                                {{ $projectType->projects()->where('status', 3)->count() }}
                                            </p>
                                            <p class="text-sm text-green-700">Proyek Selesai</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-8 h-8 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-2xl font-bold text-yellow-900">
                                                {{ $projectType->projects()->where('status', 2)->count() }}
                                            </p>
                                            <p class="text-sm text-yellow-700">Proyek Berjalan</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Projects -->
                    @if($projectType->projects()->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4">
                                Proyek Terbaru (5 Terakhir)
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Proyek
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Dibuat
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($projectType->projects()->latest()->take(5)->get() as $project)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    @can('view_projects')
                                                        <a href="{{ route('projects.show', $project) }}" 
                                                           class="text-blue-600 hover:text-blue-900">
                                                            {{ $project->name }}
                                                        </a>
                                                    @else
                                                        {{ $project->name }}
                                                    @endcan
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $statusColors = [
                                                            1 => 'bg-gray-100 text-gray-800',
                                                            2 => 'bg-yellow-100 text-yellow-800', 
                                                            3 => 'bg-green-100 text-green-800'
                                                        ];
                                                        $statusLabels = [
                                                            1 => 'Pending',
                                                            2 => 'Berjalan',
                                                            3 => 'Selesai'
                                                        ];
                                                    @endphp
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ $statusLabels[$project->status] ?? 'Unknown' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $project->created_at->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>