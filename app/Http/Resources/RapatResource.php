<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RapatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'waktu_mulai' => $this->waktu_mulai,
            'notulensi' => $this->notulensi,
            'nama' => $this->nama,
            'tipe' => $this->tipe,
            'divisi' => $this->whenLoaded('divisi'),
        ];
    }
}
