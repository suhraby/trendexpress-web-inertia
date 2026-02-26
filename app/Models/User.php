<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'identifier',
        'phone_number',
        'email',
        'password',
        'last_login_at',
        'email_verified_at',
        'has_default_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'has_default_password' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function getFullInfoAttribute(): string
    {
        return $this->attributes['name'] . ' ' . $this->attributes['surname'] . ' / ' . $this->attributes['phone_number'] . ' / ' . $this->attributes['email'];
    }

    public function cargos(): HasMany
    {
        return $this->hasMany(Cargo::class);
    }

    public function latestCargos()
    {
        return $this->cargos()->latest()->get();
    }

    public function updateLastLogin()
    {
        $this->update([
            'last_login_at' => now()
        ]);
    }

    public static function findByEmailOrPhoneOrIdentifier($identifier)
    {
        return static::where('email', $identifier)
            ->orWhere('phone_number', $identifier)
            ->orWhere('identifier', $identifier)
            ->first();
    }

    public function isTempName(): bool
    {
        return $this->name === 'waiting to fill';
    }

    public function isTempSurname(): bool
    {
        return $this->surname === 'waiting to fill';
    }

    public function isTempEmail(): bool
    {
        return str_ends_with($this->email, '@temp.local');
    }

    public function isTempPhone(): bool
    {
        return str_starts_with($this->phone_number, 'temp_');
    }

    public function needsProfileCompletion(): bool
    {
        return $this->has_default_password
            || $this->isTempEmail()
            || $this->isTempPhone()
            || $this->isTempName()
            || $this->isTempSurname();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }
}
