<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => $user->load('detailUser:id,foto,bukti_kesanggupan,bukti_mahasiswa,tanggal_wawancara,waktu_wawancara,user_id,divisi_id,jabatan_id', 'detailUser.divisi:id,nama', 'detailUser.jabatan:id,nama')
        ], 200);
    }

}
