<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public static function rules()
    {
        return [
            'username' => 'required | string | unique:users,username',
            'first_name' => 'required | string',
            'last_name' => 'required | string',
            'password' => 'required | string',
            'role' => 'required | int'
        ];
    }
}
