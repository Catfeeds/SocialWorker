<?php

namespace App\Models;


use App\Events\UserCreated;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nickname
 * @property string $avatar
 * @property int $sex
 * @property string|null $account
 * @property string|null $phone
 * @property string|null $email
 * @property int $is_bind_account
 * @property int $is_bind_phone
 * @property int $is_bind_email
 * @property int $is_bind_wx
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Models\Asset $asset
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cash[] $cashes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AssetRecord[] $incomes
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \App\Models\Receivable $receivable
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $selfGroups
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsBindAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsBindEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsBindPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsBindWx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
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

    public function bindingsEquipment()
    {
        return $this->hasMany('App\Models\Equipment');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Models\Group');
    }

    public function serviceCode()
    {
        return $this->hasOne('App\Models\ServiceCode');
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