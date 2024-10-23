<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PesankulinerResource extends JsonResource
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
                'namakuliner' => $this->namakuliner,
                'kulinerproduk' => $this->kulinerproduk->where('active', 1),
                'created_by' => $this->created_by,
                // Add other fields you need
            ];
        }


        // public function toArray($request)
        // {
        //     // Check if the 'active' status is 1
        //     if ($this->active == 1) {
        //         return [
        //             'id' => $this->id,
        //             'namawisata' => $this->namawisata,
        //             'categorywisata_id' => $this->getCategory->category_name,
        //             'deskripsi' => $this->deskripsi,
        //             'alamat' => $this->alamat,
        //             'kecamatan_id' => $this->kecamatan->Kecamatan,
        //             'instagram' => $this->instagram,
        //             'web' => $this->web,
        //             'telpon' => $this->telpon,
        //             'active' => $this->active,
        //             'views' => $this->views,
        //             'jambuka' => $this->jambuka,
        //             'jamtutup' => $this->jamtutup,
        //             'kapasitas' => $this->kapasitas,
        //             'fasilitas' => $this->fasilitas,
        //             'hargatiket' => $this->hargatiket,
        //             'latitude' => $this->latitude,
        //             'longitude' => $this->longitude,
        //             'thumbnail' => $this->thumbnail
        //         ];
        //     } else {
        //         // If the 'active' status is 0, return an empty array
        //         return [];
        //     }
            
        // }
        
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
