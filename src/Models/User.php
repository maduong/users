<?php namespace Edutalk\Base\Users\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Edutalk\Base\Users\Models\Contracts\UserModelContract;
use Edutalk\Base\Models\EloquentBase as BaseModel;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use \Edutalk\Base\ACL\Models\Traits\UserAuthorizable;

class User extends BaseModel implements UserModelContract, AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    use UserAuthorizable;

    use SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'username', 'email', 'password',
        'first_name', 'last_name', 'display_name',
        'sex', 'status', 'phone', 'mobile_phone', 'avatar',
        'birthday', 'description', 'disabled_until',
    ];

    public function getIdAttribute($value)
    {
        return (int)$value;
    }

    /**
     * Hash the password before save to database
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = str_slug($value, '_');
    }
}
