<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titleFa' => $this->title_fa,
            'titleEn' => $this->title_en,
            'slug' => $this->slug,
            'parent' => $this->parent_id,
            'descriptionFa' => $this->description_fa,
            'descriptionEn' => $this->description_en,
        ];
    }
}
