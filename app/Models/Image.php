<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'image', 'deleted_at', 'status'];

    protected $primaryKey = 'id';
}
