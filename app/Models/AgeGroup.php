<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class AgeGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['gender_id', 'max', 'min', 'deleted_at', 'status'];

    protected $primaryKey = 'id';
    
    /**
    * Boot the model.
    */
    protected static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new DeletedScope);

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('min', 'ASC')->orderBy('gender_id', 'asc');
        });
    }

    protected $appends = array('group');

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
    }

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender');
    }

    public function getGroupAttribute()
    {
        return $this->min . ' - ' . $this->max; 
    }
}
