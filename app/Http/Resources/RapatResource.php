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
            'deskripsi_tipe' => ($this->tipe == 1) ? 'Rapat Resmi' : 'Rapat Program Kerja',
            'divisi' => $this->whenLoaded('divisi'),
            'presensi' => $this->whenLoaded('presensi', function(){
                return collect($this->presensi)->each(function ($presensiItem) {
                    $presensiItem->detail_user = collect($presensiItem->user)->only(['id', 'nama'])->toArray();
                    unset($presensiItem->user);
                    return $presensiItem;
                });
            }),
        ];
    }
}
