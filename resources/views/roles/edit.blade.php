<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Role: ') . ($role->display_name ?? $role->name) }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('roles.show', $role) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Lihat Detail
                </a>
                <a href="{{ route('roles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('roles.update', $role) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Role (System Name)</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   {{ in_array($role->name, ['admin', 'user']) ? 'readonly' : '' }}
                                   required>
                            @if(in_array($role->name, ['admin', 'user']))
                                <p class="mt-1 text-sm text-gray-500">Nama role sistem tidak dapat diubah</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Nama sistem untuk role (huruf kecil, tanpa spasi)</p>
                            @endif
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Display Name -->
                        <div class="mb-4">
                            <label for="display_name" class="block text-sm font-medium text-gray-700">Nama Tampilan</label>
                            <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $role->display_name) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   required>
                            <p class="mt-1 text-sm text-gray-500">Nama yang akan ditampilkan kepada user</p>
                            @error('display_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                      placeholder="Deskripsi singkat tentang role ini...">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Permissions -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">Permissions</label>
                            
                            @foreach($availablePermissions as $category => $permissions)
                                <div class="mb-6 border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-3">{{ $category }}</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach($permissions as $key => $label)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="permissions[]" value="{{ $key }}" id="permission_{{ $key }}"
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                       {{ in_array($key, old('permissions', $role->permissions ?? [])) ? 'checked' : '' }}>
                                                <label for="permission_{{ $key }}" class="ml-2 text-sm text-gray-700">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            
                            @error('permissions')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('roles.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
