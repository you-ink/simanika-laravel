<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artikel;
use App\Models\ArtikelFile;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\ContentNotification;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ArtikelResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $artikel = Artikel::query();

        $search = isset($request->search['value']) ? $request->search['value'] : '';
        if (!empty($search)) {
            $artikel->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%'.$search.'%');
            });
        }

        $total_data = $artikel->count();
        $length = intval(isset($request->length) ? $request->length : 0);
        $start = intval(isset($request->start) ? $request->start : 0);

        if (!isset($request->length) || !isset($request->start)) {
            $artikel = $artikel->get();
        } else {
            $artikel = $artikel->skip($start)->take($length)->get();
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => ArtikelResource::collection($artikel->loadMissing(['penulis:id,nim,nama,angkatan', 'divisi:id,nama'])),
            'draw' => $request->draw,
            'recordsTotal' => $total_data,
            'recordsFiltered' => $total_data,
        ], 200);
    }

    public function new_article(Request $request)
    {
        $artikel = Artikel::query();

        $search = isset($request->search['value']) ? $request->search['value'] : '';
        if (!empty($search)) {
            $artikel->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%'.$search.'%');
            });
        }

        $total_data = $artikel->count();
        $length = intval(isset($request->length) ? $request->length : 0);
        $start = intval(isset($request->start) ? $request->start : 0);

        if (!isset($request->length) || !isset($request->start)) {
            $artikel = $artikel->orderby('created_at', 'DESC')->get();
        } else {
            $artikel = $artikel->skip($start)->take($length)->orderby('created_at', 'DESC')->get();
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => ArtikelResource::collection($artikel->loadMissing(['penulis:id,nim,nama,angkatan', 'divisi:id,nama'])),
            'draw' => $request->draw,
            'recordsTotal' => $total_data,
            'recordsFiltered' => $total_data,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $artikel = Artikel::with(['penulis:id,nim,nama,angkatan', 'divisi:id,nama', 'file'])->findOrFail($id);
        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => new ArtikelResource($artikel)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'konten' => 'required',
            'sampul' => 'required|file|mimes:jpg,png,jpeg|max:5048',
            'file' => 'required|array',
            'file.*' => 'required|file|mimes:jpg,png,jpeg|max:5048',
        ], [
            'required' => ':attribute harus diisi.',
            'array' => ':attribute harus berupa array.',
            'string' => ':attribute harus berupa string.',
            'file' => ':attribute harus berupa file.',
            'mimes' => 'File :attribute harus berformat jpg, jpeg, atau png.',
            'max' => 'File :attribute tidak boleh lebih dari :max KB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => []
            ]);
        }

        // Upload File
        $namaSampul = $this->generateRandomString(33).time();
        $ekstensiSampul = $request->sampul->extension();

        $path = Storage::putFileAs('public/images/artikel/sampul', $request->sampul, $namaSampul.".".$ekstensiSampul);
        // End Upload File

        $artikel = Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'sampul' => Storage::url($path),
            'user_id' => Auth::user()->id,
            'divisi_id' => Auth::user()->detailUser->divisi_id
        ]);

        $artikel_id = $artikel->id;

        $fileArray = [];
        foreach ($request->file as $file) {
            // Upload File
            $namaFile = $this->generateRandomString(33).time();
            $ekstensiFile = $file->extension();

            $path = Storage::putFileAs('public/images/artikel/file', $file, $namaFile.".".$ekstensiFile);
            // End Upload File

            $fileArray[] = [
                "file" => Storage::url($path),
                "artikel_id" => $artikel_id,
                "created_at" => Carbon::now()
            ];
        }

        $artikelDetail = ArtikelFile::insert($fileArray);

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'judul' => "Artikel Baru",
            'isi' => "Terdapat arikel yang baru ditambahkan. Baca sekarang!"
        ]);

        event(new ContentNotification("Terdapat arikel yang baru ditambahkan. Baca sekarang!"));

        return response()->json([
            'error' => false,
            'message' => 'Artikel berhasil ditambahkan.',
            'data' => []
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'konten' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => []
            ]);
        }

        $artikel = Artikel::findOrFail($id);
        $artikel->update($request->all());

        return response()->json([
            'error' => false,
            'message' => 'Artikel berhasil diubah.',
            'data' => []
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        // Delete Sampul
        Storage::delete(str_replace('/storage', 'public', $artikel->sampul));

        $artikelData = new ArtikelResource($artikel);
        // Delete File
        foreach ($artikelData->file->pluck('file')->toArray() as $path) {
            Storage::delete(str_replace('/storage', 'public', $path));
        }

        $artikel->delete();

        return response()->json([
            'error' => false,
            'message' => 'Artikel berhasil dihapus.',
            'data' => []
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
