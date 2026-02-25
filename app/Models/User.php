<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_type', 
        'is_owner',   
        'reputation_score', 
        'banned_at', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
            'password' => 'hashed',
        ];
    }

    public function colocations()  
    {
        return $this->belongsToMany(Colocation::class, 'user_colocation')
            ->withPivot('role', 'joined_at', 'left_at');
        
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Dettes que l'utilisateur doit payer
    public function debts()
    {
        return $this->hasMany(Payment::class, 'debtor_id');
    }

    // Argent que l'on doit rembourser à l'utilisateur
    public function credits()
    {
        return $this->hasMany(Payment::class, 'creditor_id');
    }

    public function currentColocation()
    {
        return $this->colocations()->wherePivot('left_at', null)->first();
    }

    public function isAdmin(): bool
    {
        return $this->role_type === 'admin';
    }
    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }
}
