<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $waktu = $request->query('waktu', now()->subDays(3));

        $notification = Notification::select('id', 'judul', 'isi', 'created_at')
            ->where('created_at', '>=', $waktu)
            ->get();

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => $notification
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notification = Notification::findOrFail($id);
        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => $notification
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi' => 'required',
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

        $notifikasi = Notification::create($request->all());

        return response()->json([
            'error' => false,
            'message' => 'Notifikasi berhasil ditambahkan.',
            'data' => []
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
