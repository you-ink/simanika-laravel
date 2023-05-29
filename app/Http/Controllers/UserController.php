<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DetailUser;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\ContentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::query();

        $search = isset($request->search['value']) ? $request->search['value'] : '';
        if (!empty($search)) {
            $user->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%'.$search.'%')
                    ->orWhere('nim', 'like', '%'.$search.'%');
            });
        }

        if (isset($request->status) && !empty($request->status)) {
            $user->where('status', '=', $request->status);
        }

        $total_data = $user->count();
        $length = intval(isset($request->length) ? $request->length : 0);
        $start = intval(isset($request->start) ? $request->start : 0);

        if (!isset($request->length) || !isset($request->start)) {
            $user = $user->get();
        } else {
            $user = $user->skip($start)->take($length)->get();
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => $user->load('detailUser:id,foto,bukti_kesanggupan,bukti_mahasiswa,tanggal_wawancara,waktu_wawancara,user_id,divisi_id,jabatan_id', 'detailUser.divisi:id,nama', 'detailUser.jabatan:id,nama'),
            'draw' => $request->draw,
            'recordsTotal' => $total_data,
            'recordsFiltered' => $total_data,
        ], 200);
    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'telp' => 'required',
            'angkatan' => 'required',
            'foto' => 'file|mimes:jpg,png,jpeg|max:5048',
        ], [
            'required' => ':attribute harus diisi.',
            'file' => ':attribute harus berupa file.',
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

        $user = User::findOrFail(Auth::user()->id);
        $user->update([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'angkatan' => $request->angkatan,
            'alamat' => isset($request->alamat) ? $request->alamat : $user->alamat,
        ]);

        $detailuser = DetailUser::where('user_id', Auth::user()->id)->firstOrFail();
        if (!empty($request->foto)) {
            if (!strpos($detailuser->foto, "user.png")) {
                Storage::delete(str_replace('/storage', 'public', $detailuser->foto));
            }

            // Upload File
            $namaFoto = $this->generateRandomString(33).time();
            $ekstensiFoto = $request->foto->extension();

            $pathFoto = Storage::putFileAs('public/images/user/profile', $request->foto, $namaFoto.".".$ekstensiFoto);
            // End Upload File

            $detailuser->update([
                'foto' => Storage::url($pathFoto),
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengubah profil.',
            'data' => null
        ]);
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
            'password_confirmation' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'min' => 'panjang :attribute minimal :value karakter.',
            'regex' => ':attribute harus mengandung minimal satu huruf kecil, satu huruf besar, dan satu angka.',
            'confirmed' => 'Password dan konfirmasi password tidak sama.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => null
            ]);
        }

        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->password_lama, $user->password)) {
            return response()->json([
                'error' => true,
                'message' => 'Password lama tidak sesuai dengan password saat ini.',
                'data' => null
            ]);
        }

        $user->update(['password'=>Hash::make($request->password)]);

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengubah password.',
            'data' => null
        ]);
    }

    public function set_interview(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'tanggal_wawancara' => 'required',
            'waktu_wawancara' => 'required',
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

        if(Auth::user()->level_id != 1) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized.',
                'data' => null
            ]);
        }

        $user = DetailUser::where('user_id', $request->user_id)->firstOrFail();
        $infoUser = User::findOrFail($request->user_id);
        $user->update([
            'tanggal_wawancara' => $request->tanggal_wawancara,
            'waktu_wawancara' => $request->waktu_wawancara,
        ]);

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'judul' => "Jadwal Wawancara Baru",
            'isi' => "Calon pengurus baru \"".$infoUser->nama."\" akan wawancara pada \"".
                        $request->tanggal_wawancara." ".$request->waktu_wawancara."\"."
        ]);

        event(new ContentNotification("Calon pengurus baru \"".$infoUser->nama."\" akan wawancara pada \"".
                $request->tanggal_wawancara." ".$request->waktu_wawancara."\"."));

        return response()->json([
            'error' => false,
            'message' => 'Tanggal dan waktu wawancara berhasil ditetapkan.',
            'data' => null
        ]);
    }


    public function decline_applicant(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
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

        if(Auth::user()->level_id != 1) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized.',
                'data' => null
            ]);
        }

        $user = User::findOrFail($request->user_id);
        $user->delete();

        return response()->json([
            'error' => false,
            'message' => 'Pendaftaran pengurus baru berhasil ditolak, data telah dihapus.',
            'data' => null
        ]);
    }

    public function accept_applicant(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'divisi_id' => 'required',
            'jabatan_id' => 'required',
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

        if(Auth::user()->level_id != 1) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized.',
                'data' => null
            ]);
        }

        $user = DetailUser::where('user_id', $request->user_id)->firstOrFail();
        $infoUser = User::findOrFail($request->user_id);
        $user->update([
            'divisi_id' => $request->divisi_id,
            'jabatan_id' => $request->jabatan_id,
        ]);

        $level_id = "3";
        if ($request->divisi_id == 1) {
          $level_id = "1";
        }

        if ($request->jabatan_id == "5") {
          $level_id = "2";
        }

        $infoUser->update([
            'status' => "1",
            'level_id' => $level_id
        ]);

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'judul' => "Pengurus Baru",
            'isi' => "Pendaftaran pengurus baru \"".$infoUser->nama."\" telah disetujui."
        ]);

        event(new ContentNotification("Pendaftaran pengurus baru \"".$infoUser->nama."\" telah disetujui."));

        return response()->json([
            'error' => false,
            'message' => 'Pendaftaran pengurus baru berhasil diterima.',
            'data' => null
        ]);
    }

    public function set_member(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'divisi_id' => 'required',
            'jabatan_id' => 'required',
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

        if(Auth::user()->level_id != 1) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized.',
                'data' => null
            ]);
        }

        $user = DetailUser::where('user_id', $request->user_id)->firstOrFail();
        $infoUser = User::findOrFail($request->user_id);
        $user->update([
            'divisi_id' => $request->divisi_id,
            'jabatan_id' => $request->jabatan_id,
        ]);

        $level_id = "3";
        if ($request->divisi_id == 1) {
          $level_id = "1";
        }

        if ($request->jabatan_id == "5") {
          $level_id = "2";
        }

        $infoUser->update([
            'status' => "1",
            'level_id' => $level_id
        ]);

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'judul' => "Perubahan Divisi/Jabatan",
            'isi' => "Terjadi perubahan Divisi/Jabatan pada user \"".$infoUser->nama."\"."
        ]);

        event(new ContentNotification("Terjadi perubahan Divisi/Jabatan pada user \"".$infoUser->nama."\"."));

        return response()->json([
            'error' => false,
            'message' => 'Perubahan berhasil ditetapkan.',
            'data' => null
        ]);
    }

    public function bph(Request $request)
    {
        $user = User::query();
        $user->where('level_id', '=', 1);

        $user = $user->get();

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengambil data.',
            'data' => $user->load('detailUser:id,foto,bukti_kesanggupan,bukti_mahasiswa,tanggal_wawancara,waktu_wawancara,user_id,divisi_id,jabatan_id', 'detailUser.divisi:id,nama', 'detailUser.jabatan:id,nama'),
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->softDeletes();

        return response()->json([
            'error' => false,
            'message' => 'User berhasil dinonaktifkan.',
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
