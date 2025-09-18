<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'type', // 'income' atau 'expense'
        'category', // 'project_income', 'salary', 'tax', etc
        'amount',
        'source', // 'project_payment', 'additional_service', 'maintenance', 'consultation', 'other_income'
        'tax_percentage',
        'tax_amount',
        'grand_total',
        'description',
        'transaction_date',
        'reference_number',
        'status', // 'pending', 'approved', 'paid'
        'created_by'
    ];

    // Add status constants
    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_PAID = 3;
    
    // Update casts if needed
    protected $casts = [
        'status' => 'integer',
        'amount' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'transaction_date' => 'date'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Method untuk menghitung tax dan grand total otomatis
    public function calculateTaxAndGrandTotal()
    {
        if ($this->type === 'income') {
            $this->tax_amount = $this->amount * ($this->tax_percentage / 100);
            $this->grand_total = $this->amount + $this->tax_amount;
        } else {
            $this->tax_amount = 0;
            $this->grand_total = $this->amount;
        }
        return $this;
    }

    // Event untuk auto-calculate saat saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($finance) {
            $finance->calculateTaxAndGrandTotal();
        });
    }
}
