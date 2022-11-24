<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public static function rules()
    {
        return [
            "id" => "required | numeric | exists:articles,id",
            "title" => 'string',
            "article_category_id" => 'numeric | exists:article_categories,id',
            "slug" => 'string',
            "content" => 'string',
            "image_path" => 'string'
        ];
    }
}
