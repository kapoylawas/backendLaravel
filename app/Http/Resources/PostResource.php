<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'judul' => $this->tittle,
            'content' => $this->content,
            'pesanDariSaya' => "hello",
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
