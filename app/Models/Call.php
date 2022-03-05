<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Builder;

class Call extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['caller_id', 'receiver_id', 'started_at', 'ended_at', 'status', 'deleted_at'];

    protected $primaryKey = 'id';

    protected $appends = array('call', 'duration');
    
    /**
    * Boot the model.
    */
    protected static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new DeletedScope);

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'ASC');
        });
    }


    public function getdurationAttribute()
    {
        $startTime = Carbon::parse($this->started_at);
        $endTime = Carbon::parse($this->ended_at);
        return $startTime->diff($endTime)->format('%H:%I:%S'); 
    }


    public function getcallAttribute()
    {
        $user = Auth::user();
        $type = 'Missed Call';
        if($this->status) {
            if($this->caller_id == $user->id) {
                $type = 'Called';
            }else {
                $type = 'Received';
            }
        } else {
            if($this->caller_id == $user->id) {
                $type = 'Not Received';
            }else {
                $type = 'Missed Call';
            }
        }
        
        return $type; 
    }

    public function caller()
    {
        return $this->belongsTo('App\Models\User', 'caller_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }
}
