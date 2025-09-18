@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Expense Details') }}</h4>
                    <div>
                        @if($expense->status < 5)
                            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Project section dihapus karena project_id sudah tidak ada -->
                        
                        <div class="col-md-6">
                            <h6 class="text-muted">Employee</h6>
                            <p class="fw-bold">{{ $expense->user->name ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="text-muted">Category</h6>
                            <p><span class="badge bg-secondary fs-6">{{ ucfirst($expense->category) }}</span></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Amount</h6>
                            <p class="fw-bold text-danger fs-5">Rp {{ number_format($expense->amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <p><span class="badge bg-{{ $expense->status_color }} fs-6">{{ $expense->status_text }}</span></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Payment Date</h6>
                            <p class="fw-bold">{{ $expense->payment_date->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    @if($expense->reference_number)
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-muted">Reference Number</h6>
                            <p class="fw-bold">{{ $expense->reference_number }}</p>
                        </div>
                    </div>
                    @endif

                    @if($expense->description)
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-muted">Description</h6>
                            <p>{{ $expense->description }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Created By</h6>
                            <p>{{ $expense->createdBy->name ?? 'System' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Created At</h6>
                            <p>{{ $expense->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex gap-2">
                            @if(in_array($expense->status, [1, 2, 3]))
                                <a href="{{ route('expenses.approval', $expense) }}" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Process Approval
                                </a>
                            @endif
                            
                            @if($expense->status == 4)
                                <form action="{{ route('expenses.mark-paid', $expense) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success" 
                                            onclick="return confirm('Mark this expense as paid?')">
                                        <i class="fas fa-money-bill"></i> Mark as Paid
                                    </button>
                                </form>
                            @endif

                            @if($expense->status < 5)
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this expense?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection