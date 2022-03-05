<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class Profession extends Model
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

        self::creating(function($profession){
            $profession->slug = str_replace(' ', '-', $profession->slug);
        });

        static::created(function ($profession) {
            $profession->slug = $profession->createSlug($profession->name);
            $profession->save();
        });

        self::updating(function($profession){
            $profession->slug = str_replace(' ', '-', $profession->slug);
        });

        self::deleting(function($profession) { // before delete() method call this
            $profession->delete();
        });

        self::deleted(function($profession){
            $profession->status = false;
            $profession->save();
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
     * The users that belong to the profession.
     */
    public function profile()
    {
        //return $this->belongsToMany('App\Models\Profile');
        return $this->belongsToMany('App\Models\Profile', 'profile_profession', 'profession_id', 'profile_id');
    }
}
