<?php namespace Edutalk\Base\Users\Http\Requests;

use Edutalk\Base\Http\Requests\Request;

class UpdateUserPasswordRequest extends Request
{
    public function rules()
    {
        return [
            'password' => 'required|max:60|confirmed|min:5|string'
        ];
    }
}
