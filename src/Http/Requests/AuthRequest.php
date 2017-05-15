<?php namespace Edutalk\Base\Users\Http\Requests;

use Edutalk\Base\Http\Requests\Request;

class AuthRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }
}
