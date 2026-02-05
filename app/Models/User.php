<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFullNameAttribute(): string
    {
        return $this->attributes['name'] . ' ' . $this->attributes['surname'];
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
}
