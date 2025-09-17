<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $income->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .invoice-details { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .total { text-align: right; font-weight: bold; font-size: 18px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <h2>{{ $income->invoice_number }}</h2>
    </div>

    <div class="invoice-details">
        <p><strong>Project:</strong> {{ $income->project->name }}</p>
        <p><strong>Date:</strong> {{ $income->received_date->format('d/m/Y') }}</p>
        <p><strong>Source:</strong> {{ ucfirst(str_replace('_', ' ', $income->source)) }}</p>
        <p><strong>Status:</strong> {{ $income->status_text }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $income->description ?: 'Income from ' . $income->project->name }}</td>
                <td>Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        <p>Total: Rp {{ number_format($income->amount, 0, ',', '.') }}</p>
    </div>
</body>
</html>