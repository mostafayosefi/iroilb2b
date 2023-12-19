<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PageCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titleFa' => $this->title_fa,
            'titleEn' => $this->title_en,
            'slug' => $this->slug,
            'type' => $this->type,
            'status' => $this->status,
            'images' => $this->images,
            'bodyFa' => $this->body_fa,
            'bodyEn' => $this->body_en,
            'seoDescriptionFa' => $this->seo_description_fa == null ? '' : $this->seo_description_fa,
            'seoDescriptionEn' => $this->seo_description_en == null ? '' : $this->seo_description_en,
        ];
    }
}
