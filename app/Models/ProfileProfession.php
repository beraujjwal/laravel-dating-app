<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class ProfileProfession extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profile_professions';
    
    protected $fillable = ['profile_id', 'profession_id', 'deleted_at', 'status'];

    protected $primaryKey = 'id';

    public function scopeIsActive($query)
    {
        return $query->where('status', true);
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function profession()
    {
        return $this->hasOne('App\Models\Profession');
    }
}
