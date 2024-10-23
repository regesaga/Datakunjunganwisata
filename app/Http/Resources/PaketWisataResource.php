<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaketWisataResource extends JsonResource
{
    
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function toArray($request)
        {
            // Check if the 'active' status is 1
            if ($this->active == 1) {
                return [
                    'id' => $this->id,
                    'namapaketwisata' => $this->namapaketwisata,
                    'kegiatan' => $this->kegiatan,
                    'htm' => $this->htm,
                    'nohtm' => $this->nohtm,
                    'destinasiwisata' => $this->destinasiwisata,
                    'telpon' => $this->telpon,
                    'views' => $this->views,
                    'active' => $this->active,
                    'thumbnail' => $this->thumbnail,
                    'photos' => $this->photos,
                    'rating' => $this->average_rating, // Menambahkan rata-rata rating
                ];
            } else {
                // If the 'active' status is 0, return an empty array
                return [];
            }
        }
}
