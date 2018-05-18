<?php

namespace App\Models;


use App\Events\UserCreated;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasRoles, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => UserCreated::class
    ];

    public function selfGroups()
    {
        return $this->hasMany('App\Models\Group');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Models\Group');
    }

    public function receivable()
    {
        return $this->hasOne('App\Models\Receivable');
    }

    public function asset()
    {
        return $this->hasOne('App\Models\Asset');
    }

    public function incomes()
    {
        return $this->hasMany('App\Models\AssetRecord');
    }

    public function cashes()
    {
        return $this->hasMany('App\Models\Cash');
    }
}