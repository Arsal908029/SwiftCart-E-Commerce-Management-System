<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role','phone','address','avatar','city','dob'];

    protected $hidden = ['password','remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date',
        ];
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isBuyer(): bool { return $this->role === 'buyer'; }
    public function feedbacks() { return $this->hasMany(Feedback::class); }
}
