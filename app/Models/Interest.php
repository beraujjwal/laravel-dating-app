<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class Interest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'deleted_at', 'status'];

    protected $primaryKey = 'id';
    
    /**
    * Boot the model.
    */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });

        self::creating(function($interest){
            $interest->slug = str_replace(' ', '-', $interest->slug);
        });

        static::created(function ($interest) {
            $interest->slug = $interest->createSlug($interest->name);
            $interest->save();
        });

        self::updating(function($interest){
            $interest->slug = str_replace(' ', '-', $interest->slug);
        });

        self::deleting(function($interest) { // before delete() method call this
            $interest->profiles()->each(function($profile) {
               $profile->delete(); // <-- direct deletion
            });
            // do the rest of the cleanup...
        });

        self::deleted(function($interest){
            $interest->status = false;
            $interest->save();
        });
    }
 
   /** 
    * Write code on Method
    *
    * @return response()
    */
   private function createSlug($name){
       if (static::whereSlug($slug = Str::slug($name))->exists()) {
           $max = static::whereName($name)->latest('id')->skip(1)->value('slug');
 
           if (is_numeric($max[-1])) {
               return preg_replace_callback('/(\d+)$/', function ($mathces) {
                   return $mathces[1] + 1;
               }, $max);
           }
 
           return "{$slug}-2";
       }
 
       return $slug;
   }

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * The users that belong to the interest.
     */
    public function profiles()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_interests', 'interest_id', 'profile_id');
    }
}
