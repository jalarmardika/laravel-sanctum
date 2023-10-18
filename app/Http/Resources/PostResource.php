<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentResource;

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
            'image' => $this->image != null ? url('storage/' . $this->image) : null,
            'content' => $this->content,
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s'),
            'updated_at' => date_format($this->updated_at, 'Y-m-d H:i:s'),
            'user_id' => $this->user_id,
            'author' => $this->whenLoaded('author'),
            'comment_total' => $this->whenLoaded('comments', function() {
                return $this->comments->count();
            }),
            // cara 1
            // 'comments' => $this->whenLoaded('comments', function() {
            //     return collect($this->comments)->each(function($comment) {
            //         $comment->created_at = date_format($comment->created_at, 'Y-m-d H:i:s');
            //         return $comment->load('commentator:id,name,email');
            //     });
            // }),

            // cara 2
            'comments' => $this->whenLoaded('comments', function() {
                return CommentResource::collection($this->comments->load('commentator:id,name,email'));
            })
        ];
        // return parent::toArray($request);
    }
}
