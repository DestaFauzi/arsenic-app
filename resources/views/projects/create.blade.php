<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Project Baru') }}
            </h2>
            <a href="{{ route('projects.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf

                        <!-- Project Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Project <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Masukkan nama project" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Deskripsi project...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Project Type -->
                        <div class="mb-6">
                            <label for="project_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Project <span class="text-red-500">*</span>
                            </label>
                            <select name="project_type_id" id="project_type_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="">Pilih Tipe Project</option>
                                @foreach ($projectTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('project_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_type_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- PIC -->
                        <div class="mb-6">
                            <label for="pic_user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                PIC (Person In Charge) <span class="text-red-500">*</span>
                            </label>
                            <select name="pic_user_id" id="pic_user_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="">Pilih PIC</option>
                                @foreach ($projectManagers as $manager)
                                    <option value="{{ $manager->id }}"
                                        {{ old('pic_user_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }} ({{ $manager->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pic_user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <!-- 1 = Planning (Default) -->
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Planning</option>
                                <!-- 2 = On Progress -->
                                <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>On Progress</option>
                                <!-- 3 = Completed -->
                                <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Timeline -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai
                                </label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="mb-3">
                            <label for="budget" class="form-label">{{ __('Budget') }}</label>
                            <input id="budget" type="number"
                                class="form-control @error('budget') is-invalid @enderror" name="budget"
                                value="{{ old('budget') }}" required step="0.01" oninput="calculateGrandTotal()">
                            @error('budget')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tax" class="form-label">{{ __('Tax Percentage (%)') }}</label>
                            <input id="tax" type="number" class="form-control @error('tax') is-invalid @enderror"
                                name="tax" value="{{ old('tax', 10) }}" required step="0.01" min="0"
                                max="100" oninput="calculateGrandTotal()">
                            @error('tax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text">{{ __('Tax percentage will be calculated from budget') }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Tax Amount') }}</label>
                            <input type="text" class="form-control" id="tax_amount_display" readonly>
                            <div class="form-text">{{ __('Automatically calculated: Budget × Tax %') }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Grand Total') }}</label>
                            <input type="text" class="form-control" id="grand_total_display" readonly>
                            <div class="form-text">{{ __('Automatically calculated: Budget + Tax Amount') }}</div>
                        </div>
                        {{-- class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="0" min="0" step="1000" number_format(old('budget'), 0, ',' , '.'
                                )> --}}
                        @error('budget')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('projects.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan Project
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

<script>
    function calculateGrandTotal() {
        const budget = parseFloat(document.getElementById('budget').value) || 0;
        const taxPercent = parseFloat(document.getElementById('tax').value) || 0;
        const taxAmount = (budget * taxPercent) / 100;
        const grandTotal = budget + taxAmount;

        document.getElementById('tax_amount_display').value = 'Rp ' + taxAmount.toLocaleString('id-ID');
        document.getElementById('grand_total_display').value = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    document.getElementById('budget').addEventListener('input', calculateGrandTotal);
    document.getElementById('tax').addEventListener('input', calculateGrandTotal);

    // Calculate on page load
    calculateGrandTotal();
</script>
