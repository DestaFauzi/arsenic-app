<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Project: ') . $project->name }}
            </h2>
            <a href="{{ route('projects.show', $project) }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('projects.update', $project) }}">
                        @csrf
                        @method('PUT')

                        <!-- Project Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Project <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $project->name) }}"
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
                                placeholder="Deskripsi project...">{{ old('description', $project->description) }}</textarea>
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
                                        {{ old('project_type_id', $project->project_type_id) == $type->id ? 'selected' : '' }}>
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
                                        {{ old('pic_user_id', $project->pic_user_id) == $manager->id ? 'selected' : '' }}>
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
                                <!-- 1 = Planning -->
                                <option value="1" {{ old('status', $project->status) == '1' ? 'selected' : '' }}>
                                    Planning</option>
                                <!-- 2 = On Progress -->
                                <option value="2" {{ old('status', $project->status) == '2' ? 'selected' : '' }}>
                                    On Progress</option>
                                <!-- 3 = Completed -->
                                <option value="3" {{ old('status', $project->status) == '3' ? 'selected' : '' }}>
                                    Completed</option>
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
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai
                                </label>
                                <input type="date" name="end_date" id="end_date"
                                    value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="mb-6">
                            <label for="budget_display" class="block text-sm font-medium text-gray-700 mb-2">
                                Budget (Rp)
                            </label>
                            <!-- Hidden input untuk nilai asli -->
                            <input type="hidden" name="budget" id="budget_hidden" value="{{ old('budget', $project->budget ?? 0) }}">
                            <!-- Display input untuk user -->
                            <input type="text" id="budget_display"
                                value="{{ old('budget', number_format($project->budget ?? 0, 0, ',', '.')) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="0" onkeypress="return isNumberKey(event)" oninput="updateBudget(this);">
                            @error('budget')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tax Percentage -->
                        <div class="mb-6">
                            <label for="tax" class="block text-sm font-medium text-gray-700 mb-2">
                                Tax Percentage (%)
                            </label>
                            <input type="number" name="tax" id="tax"
                                value="{{ old('tax', $project->tax_percentage ?? 10) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="10" min="0" max="100" step="0.01" oninput="calculateGrandTotal()">
                            @error('tax')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tax Amount (Read Only) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tax Amount
                            </label>
                            <input type="text" id="tax_amount_display" readonly
                                class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                        </div>

                        <!-- Grand Total (Read Only) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Grand Total
                            </label>
                            <input type="text" id="grand_total_display" readonly
                                class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('projects.show', $project) }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        // Hanya izinkan angka (0-9) dan backspace
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function updateBudget(displayInput) {
        // Hapus semua karakter non-digit
        let value = displayInput.value.replace(/\D/g, '');
        
        // Update hidden input dengan nilai numerik
        document.getElementById('budget_hidden').value = value;
        
        // Format display input
        if (value) {
            displayInput.value = parseInt(value).toLocaleString('id-ID');
        } else {
            displayInput.value = '';
        }
        
        // Recalculate grand total
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        const budgetHidden = document.getElementById('budget_hidden');
        const taxInput = document.getElementById('tax');
        
        // Ambil nilai budget dari hidden input
        const budget = parseFloat(budgetHidden.value) || 0;
        const taxPercent = parseFloat(taxInput.value) || 0;
        const taxAmount = (budget * taxPercent) / 100;
        const grandTotal = budget + taxAmount;

        // Update display fields
        document.getElementById('tax_amount_display').value = 'Rp ' + taxAmount.toLocaleString('id-ID');
        document.getElementById('grand_total_display').value = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    // Format saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const budgetDisplay = document.getElementById('budget_display');
        const budgetHidden = document.getElementById('budget_hidden');
        
        // Pastikan hidden input memiliki nilai numerik
        if (budgetHidden.value && budgetHidden.value !== '0') {
            // Format display input
            budgetDisplay.value = parseInt(budgetHidden.value).toLocaleString('id-ID');
        }
        
        // Hitung grand total saat halaman dimuat
        calculateGrandTotal();
    });

    // Event listener untuk tax input
    document.getElementById('tax').addEventListener('input', calculateGrandTotal);
</script>
