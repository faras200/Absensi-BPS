<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'karyawan_id' => $this->karyawan->id,
            'nama' => $this->karyawan->nama,
            'status' => $this->status,
            'id_finger' => $this->karyawan->id_fingerprint
        ];
    }
}
