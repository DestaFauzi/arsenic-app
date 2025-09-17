<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_NEED_ACCOUNTING_APPROVAL = 1;
    const STATUS_NEED_DEPT_HEAD_APPROVAL = 2;
    const STATUS_NEED_PRESIDENT_APPROVAL = 3;
    const STATUS_NEED_EXECUTE = 4;
    const STATUS_FINISH = 5;

    protected $fillable = [
        'project_id',
        'amount',
        'tax_percentage',
        'tax_amount',
        'grand_total',
        'source', // 'project_payment', 'additional_service', etc
        'description',
        'received_date',
        'invoice_number',
        'status', // integer: 1-5
        'created_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'received_date' => 'date',
        'status' => 'integer'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get all available status options
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_NEED_ACCOUNTING_APPROVAL => 'Need Accounting Approval',
            self::STATUS_NEED_DEPT_HEAD_APPROVAL => 'Need Dept Head Approval',
            self::STATUS_NEED_PRESIDENT_APPROVAL => 'Need President Approval',
            self::STATUS_NEED_EXECUTE => 'Ready to Execute',
            self::STATUS_FINISH => 'Completed'
        ];
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute(): string
    {
        return self::getStatusOptions()[$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            1 => 'yellow',
            2 => 'blue',
            3 => 'purple',
            4 => 'orange',
            5 => 'green',
            default => 'gray'
        };
    }
}
