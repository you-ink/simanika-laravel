<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\ContentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Http\Resources\RapatResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rapat = Rapat::query();

        $search = isset($request->search['value']) ? $request->search['value'] : '';
        if (!empty($search)) {
            $rapat->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%'.$search.'%')
                    ->orWhereRaw('IF(tipe = 1, "Rapat Resmi", "Rapat Program Kerja") like ?', ['%'.$search.'%']);
            });
        }

        if (isset($request->this_month) && $request->this_month == true) {
            $rapat->orWhereRaw("(YEAR(tanggal) = YEAR(now()) AND MONTH(tanggal) = MONTH(now()))");
        }

        $total_data = $rapat->count();
        $length = intval(isset($request->length) ? $request->length : 0);
        $start = intval(isset($request->start) ? $request->start : 0);

        if (!isset($request->length) || !isset($request->start)) {
            $rapat = $rapat->get();
        } else {
            $rapat = $rapat->skip($start)->take($length)->get();
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => RapatResource::collection($rapat->loadMissing(['divisi:id,nama'])),
            'draw' => $request->draw,
            'recordsTotal' => $total_data,
            'recordsFiltered' => $total_data,
        ], 200);
    }


    /**
     * Display a listing of the resource.
     */
    public function meeting_today()
    {
        $rapat = Rapat::query();
        $rapat->where('tanggal', '=', date('Y-m-d'));
        $rapat = $rapat->get();

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => RapatResource::collection($rapat->loadMissing(['divisi:id,nama'])),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rapat = Rapat::with(['divisi:id,nama', 'presensi:id,waktu_hadir,foto,rapat_id,user_id,peran'])->findOrFail($id);
        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => new RapatResource($rapat)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'nama' => 'required',
            'tipe' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'date' => ':attribute harus berupa tanggal.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => null
            ]);
        }

        $rapat = Rapat::create([
            'tanggal' => date("Y-m-d", strtotime($request->tanggal)),
            'waktu_mulai' => $request->waktu_mulai,
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'divisi_id' => Auth::user()->detailUser->divisi_id
        ]);

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'judul' => "Rapat Baru",
            'isi' => "Rapat baru \"".$request->nama."\" telah ditambahkan, cek jadwalnya segera."
        ]);

        event(new ContentNotification("Rapat baru \"".$request->nama."\" telah ditambahkan, cek jadwalnya segera."));

        return response()->json([
            'error' => false,
            'message' => 'Rapat berhasil ditambahkan.',
            'data' => null
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'nama' => 'required',
            'tipe' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'date' => ':attribute harus berupa tanggal.',
            'time' => ':attribute harus berupa waktu.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => null
            ]);
        }

        $rapatData = [
            'tanggal' => date("Y-m-d", strtotime($request->tanggal)),
            'waktu_mulai' => $request->waktu_mulai,
            'nama' => $request->nama,
            'tipe' => $request->tipe
        ];

        $rapat = Rapat::findOrFail($id);
        $rapat->update($rapatData);

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'judul' => "Rapat Diubah",
            'isi' => "Rapat \"".$request->nama."\" telah diubah, cek segera."
        ]);

        event(new ContentNotification("Rapat \"".$request->nama."\" telah diubah, cek segera."));

        return response()->json([
            'error' => false,
            'message' => 'Rapat berhasil diubah.',
            'data' => null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rapat = Rapat::findOrFail($id);

        $namaRapat = $rapat->nama;

        $rapat->delete();

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'judul' => "Rapat Dihapus",
            'isi' => "Rapat \"".$namaRapat."\" telah dihapus."
        ]);

        event(new ContentNotification("Rapat \"".$namaRapat."\" telah dihapus."));

        return response()->json([
            'error' => false,
            'message' => 'Rapat berhasil dihapus.',
            'data' => null
        ]);
    }

    public function upload_notulensi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'notulensi' => 'required|file|mimes:doc,docx,pdf|max:10048',
        ], [
            'required' => ':attribute harus diisi.',
            'file' => ':attribute harus berupa file.',
            'mimes' => 'File :attribute harus berformat doc, docx, atau pdf.',
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
        $namaNotulensi = $this->generateRandomString(33).time();
        $ekstensiNotulensi = $request->notulensi->extension();

        $path = Storage::putFileAs('public/document/rapat/'.$request->id, $request->notulensi, $namaNotulensi.".".$ekstensiNotulensi);
        // End Upload File

        $rapat = Rapat::findOrFail($request->id)->update([
            'notulensi' => Storage::url($path),
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Notulensi berhasil ditambahkan.',
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
