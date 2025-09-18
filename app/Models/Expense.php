<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    // Status constants for approval workflow
    const STATUS_NEED_ACCOUNTING_APPROVAL = 1;
    const STATUS_NEED_FINANCE_APPROVAL = 2;
    const STATUS_NEED_DIRECTOR_APPROVAL = 3;
    const STATUS_APPROVED = 4;
    const STATUS_PAID = 5;
    const STATUS_REJECTED = 6;

    protected $fillable = [
        'name',
        'user_id',
        'amount',
        'category',
        'description',
        'payment_date',
        'reference_number',
        'status',
        'created_by',
        'accounting_approved_at',
        'finance_approved_at',
        'director_approved_at',
        'paid_at',
        'approved_by_accounting',
        'approved_by_finance',
        'approved_by_director'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'accounting_approved_at' => 'datetime',
        'finance_approved_at' => 'datetime',
        'director_approved_at' => 'datetime',
        'paid_at' => 'datetime'
    ];

    // Hapus method ini
    // public function project(): BelongsTo
    // {
    //     return $this->belongsTo(Project::class);
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSalaryExpenses($query)
    {
        return $query->where('category', 'salary');
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_NEED_ACCOUNTING_APPROVAL => 'Need Accounting Approval',
            self::STATUS_NEED_FINANCE_APPROVAL => 'Need Finance Approval',
            self::STATUS_NEED_DIRECTOR_APPROVAL => 'Need Director Approval',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_PAID => 'Paid',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }

    // Approval relations
    public function approvedByAccounting(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_accounting');
    }

    public function approvedByFinance(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_finance');
    }

    public function approvedByDirector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_director');
    }

    /**
     * Get status text attribute
     */
    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_NEED_ACCOUNTING_APPROVAL => 'Need Accounting Approval',
            self::STATUS_NEED_FINANCE_APPROVAL => 'Need Finance Approval',
            self::STATUS_NEED_DIRECTOR_APPROVAL => 'Need Director Approval',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_PAID => 'Paid',
            self::STATUS_REJECTED => 'Rejected',
            default => 'Unknown'
        };
    }

    /**
     * Get status color attribute for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_NEED_ACCOUNTING_APPROVAL => 'warning',
            self::STATUS_NEED_FINANCE_APPROVAL => 'info',
            self::STATUS_NEED_DIRECTOR_APPROVAL => 'primary',
            self::STATUS_APPROVED => 'success',
            self::STATUS_PAID => 'success',
            self::STATUS_REJECTED => 'danger',
            default => 'secondary'
        };
    }
}
