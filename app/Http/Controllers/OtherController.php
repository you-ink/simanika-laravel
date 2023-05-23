<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class OtherController extends Controller
{

    public function get_divisi(Request $request)
    {
        $divisi = Divisi::query();
        $divisi->select('id', 'nama', 'ketua_id');
        $search = isset($request->search['value']) ? $request->search['value'] : '';
        if (!empty($search)) {
            $divisi->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%'.$search.'%');
            });
        }

        $total_data = $divisi->count();
        $length = intval(isset($request->length) ? $request->length : 0);
        $start = intval(isset($request->start) ? $request->start : 0);

        if (!isset($request->length) || !isset($request->start)) {
            $divisi = $divisi->get();
        } else {
            $divisi = $divisi->skip($start)->take($length)->get();
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => $divisi,
            'draw' => $request->draw,
            'recordsTotal' => $total_data,
            'recordsFiltered' => $total_data,
        ], 200);
    }

    public function get_jabatan(Request $request)
    {
        $waktu = $request->query('waktu', now()->subDays(3));

        $jabatan = Jabatan::query();
        $jabatan->select('id', 'nama');
        $search = isset($request->search['value']) ? $request->search['value'] : '';
        if (!empty($search)) {
            $jabatan->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%'.$search.'%');
            });
        }

        $total_data = $jabatan->count();
        $length = intval(isset($request->length) ? $request->length : 0);
        $start = intval(isset($request->start) ? $request->start : 0);

        if (!isset($request->length) || !isset($request->start)) {
            $jabatan = $jabatan->get();
        } else {
            $jabatan = $jabatan->skip($start)->take($length)->get();
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => $jabatan,
            'draw' => $request->draw,
            'recordsTotal' => $total_data,
            'recordsFiltered' => $total_data,
        ], 200);
    }
}
