<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <div class="flex space-x-2">
                @can('edit_projects')
                    <a href="{{ route('projects.edit', $project) }}"
                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('projects.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Project Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Project</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Project</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $project->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipe Project</label>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                        {{ $project->projectType->name }}
                                    </span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->status_badge }} mt-1">
                                        {{ $project->status_text }}
                                    </span>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Budget</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if ($project->budget)
                                            Rp {{ number_format($project->budget, 0, ',', '.') }}
                                        @else
                                            <span class="text-gray-400">Tidak ditentukan</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">PIC & Timeline</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">PIC (Person In
                                        Charge)</label>
                                    <div class="mt-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $project->pic->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $project->pic->email }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if ($project->start_date)
                                            {{ $project->start_date->format('d F Y') }}
                                        @else
                                            <span class="text-gray-400">Belum ditentukan</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if ($project->end_date)
                                            {{ $project->end_date->format('d F Y') }}
                                        @else
                                            <span class="text-gray-400">Belum ditentukan</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dibuat</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $project->created_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            @if ($project->description)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h3>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-line">{{ $project->description }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
