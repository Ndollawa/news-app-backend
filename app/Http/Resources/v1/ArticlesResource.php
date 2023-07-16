<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'type' => 'Articles',
            'attributes' => [
                'author' =>$this->author,
                'title' =>$this->title,
                'description' =>$this->description,
                'category' =>$this->category,
                'content' =>$this->content,
                'image_url' =>$this->image_url,
                'article_url' =>$this->article_url,
                'source_name' =>$this->source_name,
                'source' =>$this->source,
                'source_id' =>$this->source_id,
                'published_at' =>$this->published_at,
                'created_at' =>$this->created_at,
                'updated_at' =>$this->updated_at,
            ]
            ];
        
    }
}
