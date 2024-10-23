<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AkomodasiResource extends JsonResource
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
                'namaakomodasi' => $this->namaakomodasi,
                'categoryakomodasi_id' => $this->getCategoryAkomodasi->category_name,
                'deskripsi' => $this->deskripsi,
                'alamat' => $this->alamat,
                'kecamatan_id' => $this->kecamatan->Kecamatan,
                'instagram' => $this->instagram,
                'web' => $this->web,
                'telpon' => $this->telpon,
                'jambuka' => $this->jambuka,
                'jamtutup' => $this->jamtutup,
                'photos' => $this->photos,
                'views' => $this->views,
                'room' => $this->room->where('active', 1),
                'kapasitas' => $this->kapasitas,
                'latitude' => $this->latitude,
                'active' => $this->active,
                'longitude' => $this->longitude,
                'created_by_id' => $this->created_by_id,
                'thumbnail' => $this->thumbnail,
                'rating' => $this->average_rating, 
            ];
        }
}
