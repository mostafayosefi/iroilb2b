<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Filter;
use App\Models\Admin\Product;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        foreach (json_decode($this->users_management) as $user) {
            $user = User::find($user);
            $user = $user->name;
        }
        $data = [];
        $i = 0;
        $filters = json_decode($this->data);
        $filters = $filters->filter;
        foreach ($filters as $filter) {
            $value = Filter::find($filter);
            $data['filter'][$i] = $value->name_fa;
            $i++;
        }
        $i = 0;
        $tags = json_decode($this->data);
        $tags = $tags->tag;
        foreach ($tags as $tag) {
            $value = Product::find($tag);
            $data['tag'][$i] = $value->name_fa;
            $i++;
        }

        return [
            'id' => $this->id,
            'slug' => $this->slug==null?'':$this->slug,
            'verified' => $this->verified,
            'status' => $this->status,
            'filter' => $data['filter'],
            'tag' => $data['tag'],
            'bodyFa' => json_decode($this->body_fa),
            'bodyEn' => json_decode($this->body_en),
            'logo' => $this->logo,
            'users' => $user,
            'documentOne' => $this->document_one,
            'documentTow' => $this->document_tow,
            'documentThree' => $this->document_three
        ];
        return parent::toArray($request);
    }
}
