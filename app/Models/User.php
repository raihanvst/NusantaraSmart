<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
        ];
    }

    // Relasi: 1 user bisa punya banyak order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper: cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Helper: cek apakah user adalah customer
    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}