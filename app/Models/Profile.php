<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['user_id', 'gender_id', 'profession_id', 'age', 'image', 'deleted_at', 'status'];

    protected $primaryKey = 'id';
    
    /**
    * Boot the model.
    */
    protected static function boot()
    {
        parent::boot();

        self::deleting(function($profile) {
            $profile->user()->delete();
        });

        self::deleted(function($profile){
            $profile->status = false;
            $profile->save();
        });
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender');
    }

    /**
     * The profession that belong to the profile.
     */
    public function profession()
    {
        return $this->belongsToMany('App\Models\Profession', 'profile_professions', 'profile_id', 'profession_id');
    }

    /**
     * The profession that belong to the profile.
     */
    public function interests()
    {
        return $this->belongsToMany('App\Models\Interest', 'profile_interests', 'profile_id', 'interest_id');
    }
    
}
