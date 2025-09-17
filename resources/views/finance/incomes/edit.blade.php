@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit Income') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('finance.incomes.update', $income) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="project_id" class="form-label">{{ __('Project') }}</label>
                            <select class="form-select @error('project_id') is-invalid @enderror" id="project_id" name="project_id" required>
                                <option value="">{{ __('Select Project') }}</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ (old('project_id') ?? $income->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }} - Rp {{ number_format($project->grand_total, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Amount') }}</label>
                            <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') ?? $income->amount }}" required step="0.01">
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') ?? $income->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Income') }}
                            </button>
                            <a href="{{ route('finance.index') }}" class="btn btn-secondary">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection