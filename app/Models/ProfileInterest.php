<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class ProfileInterest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_interests';
    
    protected $fillable = ['profile_id', 'interest_id', 'deleted_at', 'status'];

    protected $primaryKey = 'id';

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function interest()
    {
        return $this->hasOne('App\Models\Interest');
    }
}
