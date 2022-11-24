<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "article_category" => $this->category,
            "title" => $this->title,
            "slug" => $this->slug,
            "content" => $this->content,
            "image_path" => $this->image_path,
            "created_by" => $this->whenLoaded('user'),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
