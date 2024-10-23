<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EvencalenderResource extends JsonResource
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
                'title' => $this->title,
                'deskripsi' => $this->deskripsi,
                'lokasi' => $this->lokasi,
                'jammulai' => $this->jammulai,
                'jamselesai' => $this->jamselesai,
                'active' => $this->active,
                'tanggalmulai' => $this->tanggalmulai,
                'tanggalselesai' => $this->tanggalselesai,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'photos' => $this->photos,
                'thumbnail' => $this->thumbnail

            ];
        }
}
