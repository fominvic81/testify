<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'about',
        'image',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullnameAttribute(): string
    {
        return $this->lastname . ' ' . $this->firstname;
    }

    public function addRole(string $role): void
    {
        $this->roles()->attach(Role::getByName($role));
    }

    public function hasRole(string ...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) return true;
        }
        return false;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isTeacher(): bool
    {
        return $this->hasRole('teacher');
    }

    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(TestingSession::class);
    }

    public function savedTests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class, 'saved_test_user');
    }

    public function savedCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'saved_course_user');
    }
}
