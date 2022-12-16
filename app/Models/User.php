<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user';
     
    protected $fillable = [
        'name',
        'email',
        'picture',
        'password',
    ];
    
    public function reviews() {
        return $this->hasMany('App\Models\Review', 'idUser');
    }

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
    ];
    
    function isAdmin() {
        return $this->type == 'admin';
    }
    
    function isUser() {
        return $this->type == 'user' || $this->type == 'admin';
    }
    
    function deleteUser() {
        $result = false;
        try {
            $this->delete();
            $result = true;
        } catch (\Exception $e) {}
        return $result;
    }
    
    function storeUser() {
        try {
            $this->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    function updateUser() {
        try {
            $this->update();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
