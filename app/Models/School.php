<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolFactory> */
    use HasFactory;

    protected $fillable = [
        'school_name',
        'address',
        'phone_no',
        'phone_no2',
        'email',
        'date_of_establishment',
        'longitude',
        'latitude',
        'school_logo',
        'type',
        'proprietor',
        'is_locked'
    ];

    protected $casts = [
        'date_of_establishment' => 'date:Y-m-d',
    ];
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function guardians(): HasMany
    {
        return $this->hasMany(Guardian::class);
    }
    public function levels(): HasMany
    {
        return $this->hasMany(Level::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(Year::class);
    }
}
