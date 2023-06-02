<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PresensiRapat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PresensiRapatController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required|file|mimes:jpg,png,jpeg|max:5048',
            'peran' => 'required|in:ketua,sekretaris,bendahara,sie humas,sie pdd,sie perkab,sie konsumsi',
            'rapat_id' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'date' => ':attribute harus berupa tanggal.',
            'file' => ':attribute harus berupa file.',
            'in' => ':attribute harus salah satu dari: :values.',
            'mimes' => 'File :attribute harus berformat jpg, jpeg, atau png.',
            'max' => 'File :attribute tidak boleh lebih dari :max KB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => null
            ]);
        }

        // Upload File
        $namaFoto = $this->generateRandomString(33).time();
        $ekstensiFoto = $request->foto->extension();

        $path = Storage::putFileAs('public/images/rapat/'.$request->rapat_id, $request->foto, $namaFoto.".".$ekstensiFoto);
        // End Upload File

        $date = new DateTime();
        $formattedDate = $date->format('Y-m-d H:i:s');

        $presensirapat = PresensiRapat::create([
            'waktu_hadir' => $formattedDate,
            'foto' => Storage::url($path),
            'peran' => $request->peran,
            'user_id' => Auth::user()->id,
            'rapat_id' => $request->rapat_id,
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Presensi berhasil dilakukan.',
            'data' => null
        ]);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }


}
