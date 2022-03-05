<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class Gender extends Model
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

        self::creating(function($gender){
            $gender->slug = str_replace(' ', '-', $gender->slug);
        });

        static::created(function ($gender) {
            $gender->slug = $gender->createSlug($gender->name);
            $gender->save();
        });

        self::updating(function($gender){
            $gender->slug = str_replace(' ', '-', $gender->slug);
        });

        self::deleting(function($gender) { // before delete() method call this
            $gender->profiles()->each(function($profile) {
               $profile->delete(); // <-- direct deletion
            });
            // do the rest of the cleanup...
        });

        self::deleted(function($gender){
            $gender->status = false;
            $gender->save();
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

    public function agegroups()
    {
        return $this->hasMany('App\Models\AgeGroup');
    }

    public function profiles()
    {
        return $this->hasMany('App\Models\Profile');
    }
}
