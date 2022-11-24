<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            "id" => "required | numeric | exists:users,id",
            "username" => "string",
            "first_name" => "string",
            "last_name" => "string",
            "password" => "string",
            "role" => "numeric"
        ];
    }
}
