<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => $this->user_id,
            'author' => $this->whenLoaded('author'),
            'comments' => $this->whenLoaded('comments', function() {
                return collect($this->comments)->each(function($comment) {
                    $comment->load('commentator:id,name,email');
                    return [
                        'id' => $comment->commentator->id,
                        'name' => $comment->commentator->name,
                        'email' => $comment->commentator->email
                    ];
                });
            })
        ];
        // return parent::toArray($request);
    }
}
