<?php namespace Edutalk\Base\Users\Http\Requests;

use Edutalk\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use Edutalk\Base\ACL\Repositories\RoleRepository;
use Edutalk\Base\Http\Requests\Request;
use Edutalk\Base\Users\Models\User;
use Edutalk\Base\Users\Repositories\Contracts\UserRepositoryContract;
use Edutalk\Base\Users\Repositories\UserRepository;

class CreateUserRequest extends Request
{
    public function rules()
    {
        return [
            'username' => 'required|between:3,100|string|unique:users|alpha_dash',
            'email' => 'required|between:5,255|email|unique:users',
            'password' => 'required|max:60|min:5|string',
            'status' => 'string|required|in:activated,disabled,deleted',
            'display_name' => 'string|between:1,150|nullable',
            'first_name' => 'string|between:1,100|required',
            'last_name' => 'string|between:1,100|nullable',
            'avatar' => 'string|between:1,250|nullable',
            'phone' => 'string|max:20|nullable',
            'mobile_phone' => 'string|max:20|nullable',
            'sex' => 'string|required|in:male,female,other',
            'birthday' => 'date_multi_format:Y-m-d H:i:s,Y-m-d|nullable',
            'description' => 'string|max:1000|nullable',
        ];
    }
}
