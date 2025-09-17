<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Finance Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Income Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 truncate">Total Income (Completed)</p>
                                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalIncomes, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Income Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 truncate">Pending Income</p>
                                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($pendingIncomes, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">{{ $pendingCount }} items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Expense Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-red-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 truncate">Total Expenses</p>
                                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Net Cashflow Card -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 {{ ($totalIncomes - $totalExpenses) >= 0 ? 'border-blue-500' : 'border-orange-500' }}">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 {{ ($totalIncomes - $totalExpenses) >= 0 ? 'bg-blue-100' : 'bg-orange-100' }} rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 {{ ($totalIncomes - $totalExpenses) >= 0 ? 'text-blue-600' : 'text-orange-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 truncate">Net Cashflow</p>
                                        <p class="text-2xl font-bold {{ ($totalIncomes - $totalExpenses) >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                                            Rp {{ number_format($totalIncomes - $totalExpenses, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('incomes.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Manage Incomes
                        </a>
                        <a href="{{ route('incomes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Income
                        </a>
                        @if(isset($expenses) && count($expenses) > 0)
                        <a href="#" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Manage Expenses
                        </a>
                        @endif
                        <a href="{{ route('finances.report') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            View Reports
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Incomes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Recent Incomes</h3>
                            <a href="{{ route('incomes.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                        <div class="space-y-4">
                            @forelse($recentIncomes as $income)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $income->project->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $income->source ? ucfirst(str_replace('_', ' ', $income->source)) : 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $income->received_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-green-600">Rp {{ number_format($income->grand_total ?? $income->amount, 0, ',', '.') }}</p>
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
                                                1 => 'Need Approval',
                                                2 => 'Dept Head',
                                                3 => 'President',
                                                4 => 'Execute',
                                                5 => 'Completed',
                                                default => 'Draft',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs rounded-full {{ $statusClass }}">{{ $statusText }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No recent incomes found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Expenses (if available) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Recent Expenses</h3>
                            @if(isset($expenses) && count($expenses) > 0)
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                            @endif
                        </div>
                        <div class="space-y-4">
                            @if(isset($recentExpenses) && count($recentExpenses) > 0)
                                @foreach($recentExpenses as $expense)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $expense->description }}</p>
                                            <p class="text-xs text-gray-500">{{ $expense->category ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-500">{{ $expense->created_at->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-red-600">Rp {{ number_format($expense->amount, 0, ',', '.') }}</p>
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">{{ ucfirst($expense->status ?? 'pending') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-center py-4">No recent expenses found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
