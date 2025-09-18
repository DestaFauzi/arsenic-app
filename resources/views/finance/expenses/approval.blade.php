@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Expense Approval') }}</h4>
                </div>

                <div class="card-body">
                    <!-- Expense Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">{{ __('Expense Details') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>{{ __('Project') }}:</strong> {{ $expense->project->name ?? 'N/A' }}</p>
                                    <!-- Project line dihapus -->
                                    
                                    <p><strong>{{ __('Employee') }}:</strong> {{ $expense->user->name ?? 'N/A' }}</p>
                                    <p><strong>{{ __('Amount') }}:</strong> Rp {{ number_format($expense->amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>{{ __('Category') }}:</strong> {{ ucfirst($expense->category) }}</p>
                                    <p><strong>{{ __('Payment Date') }}:</strong> {{ $expense->payment_date->format('d/m/Y') }}</p>
                                    <p><strong>{{ __('Current Status') }}:</strong> 
                                        <span class="badge bg-{{ $expense->status_color }}">{{ $expense->status_text }}</span>
                                    </p>
                                </div>
                            </div>
                            @if($expense->description)
                                <p><strong>{{ __('Description') }}:</strong> {{ $expense->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Approval Actions -->
                    <div class="row">
                        @if($expense->status == 1) <!-- Need Accounting Approval -->
                            <div class="col-md-6">
                                <form action="{{ route('expenses.approve', $expense) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="approve">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0">{{ __('Approve Expense') }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="approval_notes" class="form-label">{{ __('Approval Notes') }}</label>
                                                <textarea class="form-control" id="approval_notes" name="approval_notes" rows="3" placeholder="{{ __('Optional approval notes...') }}"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('{{ __('Approve this expense?') }}')">
                                                <i class="fas fa-check"></i> {{ __('Approve Expense') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <form action="{{ route('expenses.approve', $expense) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="reject">
                                <div class="card border-danger">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0">{{ __('Reject Expense') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="rejection_reason" class="form-label">{{ __('Rejection Reason') }} <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" placeholder="{{ __('Please provide reason for rejection...') }}" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('{{ __('Reject this expense?') }}')">
                                            <i class="fas fa-times"></i> {{ __('Reject Expense') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> {{ __('Back to Expenses') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection