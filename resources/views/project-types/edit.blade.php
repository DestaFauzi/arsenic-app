<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Tipe Proyek') }}
            </h2>
            <a href="{{ route('project-types.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('project-types.update', $projectType) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Tipe Proyek')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" 
                                         :value="old('name', $projectType->name)" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" 
                                     class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                     placeholder="Masukkan deskripsi tipe proyek...">{{ old('description', $projectType->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Is Active -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input id="is_active" type="checkbox" name="is_active" value="1" 
                                       {{ old('is_active', $projectType->is_active) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="is_active" class="ml-2 text-sm font-medium text-gray-900">
                                    Aktif
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Centang untuk mengaktifkan tipe proyek ini
                            </p>
                            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>

                        <!-- Project Count Info -->
                        <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-blue-800">
                                    Tipe proyek ini digunakan oleh <strong>{{ $projectType->projects()->count() }}</strong> proyek
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('project-types.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <x-primary-button class="ml-3">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>