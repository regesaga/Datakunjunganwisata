<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KulinerResource extends JsonResource
{
    
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function toArray($request)
        {
            if ($this->active == 1) {
                return [
                'id' => $this->id,
                'namakuliner' => $this->namakuliner,
                'deskripsi' => $this->deskripsi,
                'alamat' => $this->alamat,
                'kecamatan_id' => $this->kecamatan->Kecamatan,
                'instagram' => $this->instagram,
                'web' => $this->web,
                'telpon' => $this->telpon,
                'jambuka' => $this->jambuka,
                'jamtutup' => $this->jamtutup,
                'views' => $this->views,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'kulinerproduk' => $this->kulinerproduk->where('active', 1),
                'photos' => $this->photos,
                'active' => $this->active,
                'kapasitas' => $this->kapasitas,
                'created_by_id' => $this->created_by_id,
                'thumbnail' => $this->thumbnail,
                'rating' => $this->average_rating, 

            ];
        } else {
            // If the 'active' status is 0, return an empty array
            return [];
        }
        
        //  public function toArray($request)
        // {
        //     $data = parent::toArray($request);

        //     // Check if the 'active' status is 1
        //     if ($this->active == 1) {
        //         // Include additional data
        //         $data['additional_field'] = 'Additional Value';
        //     }

        //     return $data;
        // }
}

}
