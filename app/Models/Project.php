<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'project_type_id',
        'pic_user_id',
        'status',
        'start_date',
        'end_date',
        'budget',
        'tax_percentage',
        'tax_amount',
        'grand_total',
        'additional_info'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'additional_info' => 'array'
    ];

    public function projectType(): BelongsTo
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByProjectType($query, $projectTypeId)
    {
        return $query->where('project_type_id', $projectTypeId);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            1 => 'bg-blue-100 text-blue-800',      // Planning
            2 => 'bg-yellow-100 text-yellow-800',  // On Progress  
            3 => 'bg-green-100 text-green-800',    // Completed
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusTextAttribute()
    {
        $statusTexts = [
            1 => 'Planning',
            2 => 'On Progress', 
            3 => 'Completed'
        ];

        return $statusTexts[$this->status] ?? 'Unknown';
    }

    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class);
    }

    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function calculateTaxAmount()
    {
        if ($this->budget && $this->tax_percentage) {
            return ($this->budget * $this->tax_percentage) / 100;
        }
        return 0;
    }

    public function calculateGrandTotal()
    {
        return $this->budget + $this->calculateTaxAmount();
    }

    // Automatically calculate tax and grand total when budget or tax_percentage changes
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($project) {
            if ($project->budget && $project->tax_percentage) {
                $project->tax_amount = $project->calculateTaxAmount();
                $project->grand_total = $project->calculateGrandTotal();
            }
        });
    }
}
