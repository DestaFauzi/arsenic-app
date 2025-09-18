<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Incomes Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Pending Incomes Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Pending Expenses</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Total Amount</p>
                                        <p class="text-lg font-semibold text-blue-600">Rp
                                            {{ number_format($pendingExpenses, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Awaiting Approval
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Incomes Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Total Expenses</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $paidCount }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Total Amount</p>
                                        <p class="text-lg font-semibold text-green-600">Rp
                                            {{ number_format($totalExpenses, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Completed & Executed
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <form method="GET" action="{{ route('expenses.index') }}" class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category" id="category"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}"
                                {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Need Accounting Approval
                        </option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Need Finance Approval
                        </option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Need Director Approval
                        </option>
                        <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Approved</option>
                        <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Filter
                    </button>
                    <a href="{{ route('expenses.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Reset
                    </a>
                </div>
            </form>


            <!-- Incomes Table -->

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($expenses as $expense)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $expense->payment_date->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $expense->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ ucfirst($expense->category) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Rp
                                        {{ number_format($expense->amount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $expense->user->name ?? 'N/A' }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = match ($expense->status) {
                                            1 => 'bg-yellow-100 text-yellow-800',
                                            2 => 'bg-orange-100 text-orange-800',
                                            3 => 'bg-purple-100 text-purple-800',
                                            4 => 'bg-blue-100 text-blue-800',
                                            5 => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                        $statusText = match ($expense->status) {
                                            1 => 'Need Approval by Accounting',
                                            2 => 'Need Approval by Dept Head Accounting',
                                            3 => 'Need Approval by President Director',
                                            4 => 'Need Execute Expenses',
                                            5 => 'Finish',
                                            default => $expense->status,
                                        };
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('expenses.show', $expense) }}"
                                            class="text-indigo-600 hover:text-indigo-900">View</a>

                                        <!-- Export button for approved expenses -->
                                        @if ($expense->status >= 4 && $expense->invoice_number)
                                            <a href="{{ route('expenses.export', $expense) }}"
                                                class="text-orange-600 hover:text-orange-900">
                                                <i class="fas fa-download"></i> Invoice
                                            </a>
                                        @endif

                                        @can('manage_expenses')
                                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $income->received_date->format('d/m/Y') }}</div>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                    No expenses found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $expenses->withQueryString()->links() }}
            </div>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>
