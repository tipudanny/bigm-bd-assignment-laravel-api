<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'division' => $this->division,
            'district' => $this->district,
            'upazila' => $this->upazila,
            'address_line' => $this->address_line,
            'language_proficiency' => $this->language_proficiency,
            'educations' => json_decode($this->educations),
            'trainings' => json_decode($this->trainings),
            'profile_image' => 'images/'.$this->profile_image,
            'cv_attachment' => 'docs/'.$this->cv_attachment,
        ];
    }
}
