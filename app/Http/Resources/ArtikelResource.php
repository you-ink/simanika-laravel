<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArtikelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // $files = $this->file->map(function ($file) {
        //     return [
        //         'id' => $file->id,
        //         'file' => $file->file
        //     ];
        // });

        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'konten' => $this->konten,
            'sampul' => '/simanika'.$this->sampul,
            'tanggal' => date_format($this->created_at, "Y-m-d h:i:s"),
            'file' => $this->whenLoaded('file', function () {
                $files = $this->file->pluck('file')->toArray();
                foreach ($files as &$file) {
                    $file = '/simanika' . $file;
                }
                return $files;
            }),
            'penulis' => $this->whenLoaded('penulis'),
            'divisi' => $this->whenLoaded('divisi'),
        ];
    }
}
