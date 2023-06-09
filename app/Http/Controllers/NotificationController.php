<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $waktu = $request->query('waktu', now()->subDays(7));
        $notification = Notification::query();
        $notification->select('id', 'judul', 'isi', 'created_at')->where('created_at', '>', $waktu);
        $search = isset($request->search['value']) ? $request->search['value'] : '';
        if (!empty($search)) {
            $notification->where(function ($query) use ($search) {
                $query->where('judul', 'like', '%'.$search.'%')
                    ->orWhere('isi', 'like', '%'.$search.'%');
            });
        }

        $userLogin = Auth::user()->id;
        $user = User::findOrFail($userLogin);
        if ($user->status != 1) {
            $notification->where('user_id', '=', $user->id);
        } else if ($user->detailUser->divisi->id != 1) {
            $notification->whereRaw("(user_id is null || user_id = ?)", $user->id);
        }

        $total_data = $notification->count();
        $length = intval(isset($request->length) ? $request->length : 0);
        $start = intval(isset($request->start) ? $request->start : 0);

        if (!isset($request->length) || !isset($request->start)) {
            $notification = $notification->orderBy('created_at', 'DESC')->get();
        } else {
            $notification = $notification->orderBy('created_at', 'DESC')->skip($start)->take($length)->get();
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => $notification,
            'draw' => $request->draw,
            'recordsTotal' => $total_data,
            'recordsFiltered' => $total_data,
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
                'data' => null
            ]);
        }

        $notifikasi = Notification::create($request->all());

        return response()->json([
            'error' => false,
            'message' => 'Notifikasi berhasil ditambahkan.',
            'data' => null
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
