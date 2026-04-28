<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements \Filament\Models\Contracts\FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, \Spatie\Permission\Traits\HasRoles;

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->is_active && $this->hasAnyRole(['administrator', 'staf_operasional']);
    }

    public function assetUsages()
    {
        return $this->hasMany(AssetUsage::class);
    }

    public function stockRequests()
    {
        return $this->hasMany(StockRequest::class, 'requested_by');
    }

    public function approvedStockRequests()
    {
        return $this->hasMany(StockRequest::class, 'approved_by');
    }

    public function createdMutations()
    {
        return $this->hasMany(AssetMutation::class, 'created_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('administrator');
    }

    public function isStaff(): bool
    {
        return $this->hasRole('staf_operasional');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
