<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\Scopes\UserScope;


use Laravel\Passport\HasApiTokens; 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'online',
        'provider_id',
        'provider'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'provider_id',
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
    
    /**
    * Boot the model.
    */
    protected static function boot()
    {
        parent::boot();

        self::deleted(function($user){
            $user->status = false;
            $user->save();
        });
    }
    
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        //static::addGlobalScope(new UserScope);
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    /*public function user_professions()
    {
        return $this->hasManyThrough('App\Models\Profession', 'App\Models\UserProfession', 'user_id', 'profession_id');
    }*/
}
