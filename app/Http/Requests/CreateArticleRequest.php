<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            "article_category_id" => "required | numeric | exists:article_categories,id",
            "title" => 'required | string',
            "slug" => 'required | string',
            "content" => 'required | string',
            "image_path" => 'string',
            "updated_user_id" => 'required | numeric | exists:users,id'
        ];
    }
}
