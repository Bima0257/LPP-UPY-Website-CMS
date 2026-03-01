<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $guarded = ['id'];

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
            'password' => 'hashed',
        ];
    }

    public function carousels(): HasMany
    {
        return $this->hasMany(Carousels::class, 'author_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Documents::class, 'uploaded_by');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Posts::class);
    }

    public function foto(): HasMany
    {
        return $this->hasMany(Galleries::class);
    }

    public function proker(): HasMany
    {
        return $this->hasMany(WorkProgram::class);
    }
}
