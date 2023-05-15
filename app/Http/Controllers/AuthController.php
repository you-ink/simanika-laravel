<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DetailUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'email' => 'alamat email pada kolom :attribute tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => []
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => true,
                'message' => 'Pastikan email dan password anda benar.',
                'data' => []
            ]);
        }

        $token = $user->createToken("auth-token")->plainTextToken;

        return response()->json([
            'error' => false,
            'message' => 'Berhasil login.',
            'data' => [
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }

    public function akun(Request $request)
    {
        $user = Auth::user()->with('detailUser')->first();
        return response()->json($user->load('detailUser:id,foto,bukti_kesanggupan,bukti_mahasiswa,tanggal_wawancara,waktu_wawancara,user_id,divisi_id,jabatan_id', 'detailUser.divisi:id,nama', 'detailUser.jabatan:id,nama'), 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'nim' => 'required',
            'angkatan' => 'required',
            'telp' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
            'password_confirmation' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'email' => ':attribute harus berupa email yang valid.',
            'min' => 'panjang :attribute minimal :value karakter.',
            'regex' => ':attribute harus mengandung minimal satu huruf kecil, satu huruf besar, dan satu angka.',
            'confirmed' => 'Password dan konfirmasi password tidak sama.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => []
            ]);
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'telp' => $request->telp,
            'password' => Hash::make($request->password),
        ]);

        $user_id = $user->id;

        $detailuser = DetailUser::create([
            'user_id' => $user_id,
            'foto' =>  '/assets/img/user.png',
            'jabatan_id' => 6
        ]);

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'judul' => "Anggota Baru",
            'isi' => "Anggota baru telah mendaftar. Cek sekarang!"
        ]);

        event(new ContentNotification("Anggota baru telah mendaftar. Cek sekarang!"));

        return response()->json([
            'error' => false,
            'message' => 'Berhasil melakukan registrasi. Silahkan Login.',
            'data' => []
        ]);
    }

    public function complete_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bukti_kesanggupan' => 'file|mimes:jpg,png,jpeg|max:5048',
            'bukti_mahasiswa' => 'file|mimes:jpg,png,jpeg|max:5048',
            'alamat' => 'string',
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
                'data' => []
            ]);
        }

        $detailuser = DetailUser::where('user_id', Auth::user()->id)->firstOrFail();

        if (!empty($request->bukti_kesanggupan)) {
            if (!empty($detailuser->bukti_kesanggupan)) {
                Storage::delete(str_replace('/storage', 'public', $detailuser->bukti_kesanggupan));
            }

            // Upload File
            $namaKesanggupan = $this->generateRandomString(33).time();
            $ekstensiKesanggupan = $request->bukti_kesanggupan->extension();

            $pathKesanggupan = Storage::putFileAs('public/images/user/bukti-kesanggupan', $request->bukti_kesanggupan, $namaKesanggupan.".".$ekstensiKesanggupan);
            // End Upload File

            $detailuser->update([
                'bukti_kesanggupan' => Storage::url($pathKesanggupan),
            ]);
        }

        if (!empty($request->bukti_mahasiswa)) {
            if (!empty($detailuser->bukti_mahasiswa)) {
                Storage::delete(str_replace('/storage', 'public', $detailuser->bukti_mahasiswa));
            }

            // Upload File
            $namaBuktiMahasiswa = $this->generateRandomString(33).time();
            $ekstensiBuktiMahasiswa = $request->bukti_mahasiswa->extension();

            $pathBuktiMahasiswa = Storage::putFileAs('public/images/user/bukti-mahasiswa', $request->bukti_mahasiswa, $namaBuktiMahasiswa.".".$ekstensiBuktiMahasiswa);
            // End Upload File

            $detailuser->update([
                'bukti_mahasiswa' => Storage::url($pathBuktiMahasiswa),
            ]);
        }

        if (!empty($request->alamat)) {
            User::findOrFail(Auth::user()->id)->update(['alamat'=>$request->alamat]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Berhasil melengkapi profil.',
            'data' => []
        ]);
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
                'data' => []
            ]);
        }

        $user = User::findOrFail(Auth::user()->id);
        $user->update([
            'nama' => $request->nama,
            'telp' => $request->telp,
            'angkatan' => $request->angkatan,
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
            'data' => []
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
                'data' => []
            ]);
        }

        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->password_lama, $user->password)) {
            return response()->json([
                'error' => true,
                'message' => 'Password lama tidak sesuai dengan password saat ini.',
                'data' => []
            ]);
        }

        $user->update(['password'=>Hash::make($request->password)]);

        return response()->json([
            'error' => false,
            'message' => 'Berhasil mengubah password.',
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
