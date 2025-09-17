<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Approval Income') }} - {{ $income->project->name ?? 'N/A' }}
            </h2>
            <a href="{{ route('incomes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Detail Income Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-file-invoice-dollar mr-2 text-blue-600"></i>Detail Income
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Project:</span>
                                <span class="text-gray-900">{{ $income->project->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Source:</span>
                                <span class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $income->source)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Invoice Number:</span>
                                <span class="text-gray-900">{{ $income->invoice_number ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Amount:</span>
                                <span class="text-gray-900 font-semibold">Rp {{ number_format($income->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Tax ({{ $income->tax_percentage ?? 0 }}%):</span>
                                <span class="text-gray-900">Rp {{ number_format($income->tax_amount ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-2">
                                <span class="font-bold text-gray-700">Grand Total:</span>
                                <span class="text-green-600 font-bold text-lg">Rp {{ number_format($income->grand_total ?? $income->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Date & User Information -->
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Received Date:</span>
                                <span class="text-gray-900">{{ $income->received_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Created By:</span>
                                <span class="text-gray-900">{{ $income->createdBy->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium text-gray-600">Created At:</span>
                                <span class="text-gray-900">{{ $income->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($income->description)
                        <div class="mt-6 pt-4 border-t">
                            <h4 class="font-medium text-gray-700 mb-2">Description:</h4>
                            <p class="text-gray-600 bg-gray-50 p-3 rounded">{{ $income->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tracking Process Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                        <i class="fas fa-route mr-2 text-green-600"></i>Tracking Proses Approval
                    </h3>

                    @php
                        $currentStatus = $income->status;
                        $statusClass = match ($currentStatus) {
                            1 => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            2 => 'bg-blue-100 text-blue-800 border-blue-200',
                            3 => 'bg-purple-100 text-purple-800 border-purple-200',
                            4 => 'bg-orange-100 text-orange-800 border-orange-200',
                            5 => 'bg-green-100 text-green-800 border-green-200',
                            default => 'bg-gray-100 text-gray-800 border-gray-200',
                        };
                        $statusText = match ($currentStatus) {
                            1 => 'Menunggu Approval Accounting',
                            2 => 'Menunggu Approval Dept Head Accounting',
                            3 => 'Menunggu Approval President Director',
                            4 => 'Menunggu Execute Income',
                            5 => 'Completed',
                            default => 'Status Tidak Diketahui',
                        };
                    @endphp

                    <!-- Current Status Alert -->
                    <div class="border-l-4 border-blue-500 bg-blue-50 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <span class="font-medium">Status Saat Ini:</span> {{ $statusText }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Steps -->
                    <div class="space-y-4">
                        <!-- Step 1: Accounting Approval -->
                        <div class="flex items-center p-4 rounded-lg {{ $currentStatus >= 1 ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }} border">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentStatus >= 2 ? 'bg-green-500 text-white' : ($currentStatus == 1 ? 'bg-yellow-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                                    @if($currentStatus >= 2)
                                        <i class="fas fa-check"></i>
                                    @elseif($currentStatus == 1)
                                        <i class="fas fa-clock"></i>
                                    @else
                                        <i class="fas fa-calculator"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Accounting Approval</h4>
                                <p class="text-sm text-gray-600">
                                    @if($currentStatus >= 2)
                                        <span class="text-green-600 font-medium">✓ Approved by Accounting</span>
                                    @elseif($currentStatus == 1)
                                        <span class="text-yellow-600 font-medium">⏳ Pending Approval</span>
                                    @else
                                        <span class="text-gray-500">⏸ Waiting</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Step 2: Dept Head Approval -->
                        <div class="flex items-center p-4 rounded-lg {{ $currentStatus >= 2 ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }} border">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentStatus >= 3 ? 'bg-green-500 text-white' : ($currentStatus == 2 ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                                    @if($currentStatus >= 3)
                                        <i class="fas fa-check"></i>
                                    @elseif($currentStatus == 2)
                                        <i class="fas fa-clock"></i>
                                    @else
                                        <i class="fas fa-user-tie"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Dept Head Accounting Approval</h4>
                                <p class="text-sm text-gray-600">
                                    @if($currentStatus >= 3)
                                        <span class="text-green-600 font-medium">✓ Approved by Dept Head</span>
                                    @elseif($currentStatus == 2)
                                        <span class="text-blue-600 font-medium">⏳ Pending Approval</span>
                                    @else
                                        <span class="text-gray-500">⏸ Waiting</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Step 3: President Approval -->
                        <div class="flex items-center p-4 rounded-lg {{ $currentStatus >= 3 ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }} border">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentStatus >= 4 ? 'bg-green-500 text-white' : ($currentStatus == 3 ? 'bg-purple-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                                    @if($currentStatus >= 4)
                                        <i class="fas fa-check"></i>
                                    @elseif($currentStatus == 3)
                                        <i class="fas fa-clock"></i>
                                    @else
                                        <i class="fas fa-crown"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-sm font-medium text-gray-900">President Director Approval</h4>
                                <p class="text-sm text-gray-600">
                                    @if($currentStatus >= 4)
                                        <span class="text-green-600 font-medium">✓ Approved by President</span>
                                    @elseif($currentStatus == 3)
                                        <span class="text-purple-600 font-medium">⏳ Pending Approval</span>
                                    @else
                                        <span class="text-gray-500">⏸ Waiting</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Step 4: Execute Income -->
                        <div class="flex items-center p-4 rounded-lg {{ $currentStatus >= 4 ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }} border">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $currentStatus >= 5 ? 'bg-green-500 text-white' : ($currentStatus == 4 ? 'bg-orange-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                                    @if($currentStatus >= 5)
                                        <i class="fas fa-check"></i>
                                    @elseif($currentStatus == 4)
                                        <i class="fas fa-clock"></i>
                                    @else
                                        <i class="fas fa-play-circle"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Execute Income</h4>
                                <p class="text-sm text-gray-600">
                                    @if($currentStatus >= 5)
                                        <span class="text-green-600 font-medium">✓ Income Executed</span>
                                    @elseif($currentStatus == 4)
                                        <span class="text-orange-600 font-medium">⏳ Ready to Execute</span>
                                    @else
                                        <span class="text-gray-500">⏸ Waiting</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approval Actions Section -->
            @if($income->status < 5)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                            <i class="fas fa-tasks mr-2 text-purple-600"></i>Approval Actions
                        </h3>

                        <div class="flex justify-end space-x-4">
                            <!-- Accounting Approval -->
                            @can('approve_incomes_accounting')
                                @if($income->status == 1)
                                    <form action="{{ route('incomes.approve.accounting', $income) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105" onclick="return confirm('Approve income ini sebagai Accounting?')">
                                            <i class="fas fa-check mr-2"></i>
                                            Approve as Accounting
                                        </button>
                                    </form>
                                @endif
                            @endcan

                            <!-- Dept Head Approval -->
                            @can('approve_incomes_dept_head')
                                @if($income->status == 2)
                                    <form action="{{ route('incomes.approve.dept_head', $income) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105" onclick="return confirm('Approve income ini sebagai Dept Head?')">
                                            <i class="fas fa-check mr-2"></i>
                                            Approve as Dept Head
                                        </button>
                                    </form>
                                @endif
                            @endcan

                            <!-- President Approval -->
                            @can('approve_incomes_president')
                                @if($income->status == 3)
                                    <form action="{{ route('incomes.approve.president', $income) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105" onclick="return confirm('Approve income ini sebagai President Director?')">
                                            <i class="fas fa-check mr-2"></i>
                                            Approve as President
                                        </button>
                                    </form>
                                @endif
                            @endcan

                            <!-- Execute Income -->
                            @can('execute_incomes')
                                @if($income->status == 4)
                                    <form action="{{ route('incomes.execute', $income) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105" onclick="return confirm('Execute income ini? Setelah di-execute, income akan masuk ke Total Incomes.')">
                                            <i class="fas fa-play-circle mr-2"></i>
                                            Execute Income
                                        </button>
                                    </form>
                                @endif
                            @endcan

                            <!-- Reject Button (Only for Dept Head and President) -->
                            @if(in_array($income->status, [2, 3]))
                                @canany(['approve_incomes_dept_head', 'approve_incomes_president'])
                                    <form action="{{ route('incomes.reject', $income) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105" onclick="return confirm('Reject income ini? Income akan dikembalikan ke status Need Accounting Approval.')">
                                            <i class="fas fa-times mr-2"></i>
                                            Reject
                                        </button>
                                    </form>
                                @endcanany
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Completed Status -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center justify-center text-center">
                        <div>
                            <i class="fas fa-check-circle text-green-500 text-4xl mb-3"></i>
                            <h3 class="text-lg font-semibold text-green-800 mb-2">Income Telah Selesai</h3>
                            <p class="text-green-600">Income ini telah melalui semua proses approval dan sudah di-execute. Nilai sudah masuk ke Total Incomes.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>