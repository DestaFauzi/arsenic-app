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
                                        <p class="text-sm font-medium text-gray-600">Pending Incomes</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $pendingCount }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Total Amount</p>
                                        <p class="text-lg font-semibold text-blue-600">Rp
                                            {{ number_format($pendingIncomes, 0, ',', '.') }}</p>
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
                                        <p class="text-sm font-medium text-gray-600">Total Incomes</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $completedCount }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Total Amount</p>
                                        <p class="text-lg font-semibold text-green-600">Rp
                                            {{ number_format($totalIncomes, 0, ',', '.') }}</p>
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


            <form method="GET" action="{{ route('incomes.index') }}" class="grid grid-cols-1 md:grid-cols-2 gap-2">
                {{-- <div> --}}
                {{-- <label for="project_id" class="block text-sm font-medium text-gray-700">Project</label>
                            {{-- <select name="project_id" id="project_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Projects</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select> --}}
                {{-- </div> --}}

                {{-- <div>
                            <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                            <select name="source" id="source"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Sources</option>
                                @foreach ($sources as $source)
                                    <option value="{{ $source }}"
                                        {{ request('source') == $source ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $source)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Status</option>
                        @foreach ($statuses as $key => $value)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                        Filter
                    </button>
                    <a href="{{ route('incomes.index') }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Reset
                    </a>
                </div>
            </form>

            <!-- Action Buttons -->
            {{-- <div class="mb-4">
                        <a href="{{ route('incomes.create') }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Add New Income
                        </a>
                    </div> --}}

            <!-- Incomes Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Invoice</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Project</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tax</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Grand Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Source</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($incomes as $income)
                            <tr>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $income->received_date->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $income->invoice_number ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $income->project->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Rp
                                        {{ number_format($income->amount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $income->tax_percentage }}% (Rp
                                        {{ number_format($income->tax_amount ?? 0, 0, ',', '.') }})
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Rp
                                        {{ number_format($income->grand_total ?? $income->amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $income->source)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = match ($income->status) {
                                            1 => 'bg-yellow-100 text-yellow-800',
                                            2 => 'bg-orange-100 text-orange-800',
                                            3 => 'bg-purple-100 text-purple-800',
                                            4 => 'bg-blue-100 text-blue-800',
                                            5 => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                        $statusText = match ($income->status) {
                                            1 => 'Need Approval by Accounting',
                                            2 => 'Need Approval by Dept Head Accounting',
                                            3 => 'Need Approval by President Director',
                                            4 => 'Need Execute Incomes',
                                            5 => 'Finish',
                                            default => $income->status,
                                        };
                                    @endphp
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('incomes.show', $income) }}"
                                            class="text-indigo-600 hover:text-indigo-900">View</a>

                                        <!-- Export button for approved incomes -->
                                        @if ($income->status >= 4 && $income->invoice_number)
                                            <a href="{{ route('incomes.export', $income) }}"
                                                class="text-orange-600 hover:text-orange-900">
                                                <i class="fas fa-download"></i> Invoice
                                            </a>
                                        @endif

                                        @can('manage_incomes')
                                            <form action="{{ route('incomes.destroy', $income) }}" method="POST"
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
                                    No incomes found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $incomes->withQueryString()->links() }}
            </div>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>
