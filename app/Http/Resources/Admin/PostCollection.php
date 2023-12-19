<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PostCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->seo_description==null){
            $seoDes='';
        }else{
            $seoDes=$this->seo_description;
        }
        if ($this->seo_kaywords == null) {
            $tag = [];
        } else {
            $tag = explode(",", $this->seo_kaywords);
        }
        if ($this->labels == null) {
            $labels = [];
        } else {
            $labels = explode(",", $this->labels);
        }
        if ($this->categories == null) {
            $categories = [];
        } else {
            $categories = explode(",", $this->categories);
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'language' => $this->language,
            'status' => $this->status,
            'images' => $this->images,
            'categories' => $categories,
            'labels' => $labels,
            'body' => $this->body,
            'seoDes' => $seoDes,
            'seoKay' => $tag,
            'time'=>$this->updated_at,
            'created'=>$this->created_at,
            'views' => $this->views_count,
        ];
    }
}
