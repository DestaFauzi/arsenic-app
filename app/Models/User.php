<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime'
        ];
    }

    /**
     * Relationship dengan Role
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign role ke user
     */
    public function assignRole($role): void
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }

        if ($role && !$this->hasRole($role)) {
            $this->roles()->attach($role->id);
        }
    }

    /**
     * Remove role dari user
     */
    public function removeRole($role): void
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }

        if ($role) {
            $this->roles()->detach($role->id);
        }
    }

    /**
     * Check apakah user memiliki role tertentu
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return $this->roles->contains($role);
    }

    /**
     * Check apakah user memiliki salah satu dari roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    /**
     * Check apakah user memiliki semua roles
     */
    public function hasAllRoles(array $roles): bool
    {
        return collect($roles)->every(fn($role) => $this->hasRole($role));
    }

    /**
     * Check apakah user memiliki permission tertentu
     */
    public function hasPermission(string $permission): bool
    {
        return $this->roles->some(fn($role) => $role->hasPermission($permission));
    }

    /**
     * Get semua permissions user
     */
    public function getAllPermissions(): array
    {
        return $this->roles
            ->flatMap(fn($role) => $role->permissions ?? [])
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Get role names as string
     */
    public function getRoleNamesAttribute(): string
    {
        return $this->roles->pluck('display_name')->join(', ');
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for users with specific role
     */
    public function scopeWithRole($query, $roleName)
    {
        return $query->whereHas('roles', function($q) use ($roleName) {
            $q->where('name', $roleName);
        });
    }
    
    public function managedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'pic_user_id');
    }
    
    public function scopeProjectManagers($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('name', 'project_manager');
        });
    }
}
