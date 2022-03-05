<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class Friend extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'friend_id', 'requested_at', 'action_at', 'status', 'deleted_at'];

    protected $primaryKey = 'id';

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'friend_id', 'id');
    }
}
