<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pemasukan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header with Back Button -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Detail Pemasukan</h3>
                        <a href="{{ route('incomes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <!-- Income Details Card -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Informasi Pemasukan
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Detail lengkap data pemasukan
                            </p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                                <!-- Project -->
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Project
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $income->project->name ?? 'N/A' }}
                                    </dd>
                                </div>

                                <!-- Amount -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Jumlah
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span class="text-lg font-bold text-green-600">
                                            Rp {{ number_format($income->amount, 0, ',', '.') }}
                                        </span>
                                    </dd>
                                </div>

                                <!-- Tax Information -->
                                @if($income->tax_percentage > 0)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Pajak ({{ $income->tax_percentage }}%)
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        Rp {{ number_format($income->tax_amount, 0, ',', '.') }}
                                    </dd>
                                </div>

                                <!-- Grand Total -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Total Bersih
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span class="text-lg font-bold text-blue-600">
                                            Rp {{ number_format($income->grand_total, 0, ',', '.') }}
                                        </span>
                                    </dd>
                                </div>
                                @endif

                                <!-- Source -->
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Sumber
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst(str_replace('_', ' ', $income->source)) }}
                                        </span>
                                    </dd>
                                </div>

                                <!-- Status -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Status
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        @php
                                            $statusClass = match($income->status) {
                                                1 => 'bg-yellow-100 text-yellow-800',
                                                2 => 'bg-blue-100 text-blue-800', 
                                                3 => 'bg-purple-100 text-purple-800',
                                                4 => 'bg-orange-100 text-orange-800',
                                                5 => 'bg-green-100 text-green-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ $income->status_text }}
                                        </span>
                                    </dd>
                                </div>

                                <!-- Description -->
                                @if($income->description)
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Deskripsi
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $income->description }}
                                    </dd>
                                </div>
                                @endif

                                <!-- Invoice Number -->
                                @if($income->invoice_number)
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Nomor Invoice
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $income->invoice_number }}
                                    </dd>
                                </div>
                                @endif

                                <!-- Received Date -->
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Tanggal Diterima
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $income->received_date->format('d F Y') }}
                                    </dd>
                                </div>

                                <!-- Created By -->
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Dibuat Oleh
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $income->createdBy->name ?? 'N/A' }}
                                    </dd>
                                </div>

                                <!-- Created At -->
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        Tanggal Dibuat
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $income->created_at->format('d F Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex space-x-3">
                        <!-- Export Invoice Button - Show for approved/completed incomes -->
                        @if($income->status >= 4 && $income->invoice_number)
                            <a href="{{ route('incomes.export', $income) }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-download"></i> Download Invoice
                            </a>
                        @endif

                        @if($income->status < 5)
                            <a href="{{ route('incomes.approval', $income) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-check"></i> Proses Approval
                            </a>
                        @endif
                        
                        @can('manage_incomes')
                            <a href="{{ route('incomes.edit', $income) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <form method="POST" action="{{ route('incomes.destroy', $income) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>