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
                'data' => null
            ]);
        }

        $user = User::select(['id', 'nama', 'status'])->where('email', $request->email)->first();

        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => 'Pastikan email dan password anda benar.',
        //         'data' => null
        //     ]);
        // }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = $user->createToken("auth-token")->plainTextToken;
            Auth::login($user);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Pastikan email dan password anda benar.',
                'data' => null
            ]);
        }

        $user = $user->load('detailUser:id,foto,user_id,jabatan_id,divisi_id', 'detailUser.jabatan:id,nama');

        return response()->json([
            'error' => false,
            'message' => 'Berhasil login.',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
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
            'min' => 'panjang :attribute minimal :min karakter.',
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

        $cek_nim_email = User::where('email', $request->email)->orWhere('nim', $request->nim)->get()->count();
        if ($cek_nim_email > 0) {
            return response()->json([
                'error' => true,
                'message' => "Email atau NIM telah terpakai. Silahkan hubungi CS untuk konfirmasi.",
                'data' => null
            ]);
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'telp' => $request->telp,
            'password' => Hash::make($request->password),
            'status' => '2',
            'level_id' => '3'
        ]);

        $user_id = $user->id;

        $detailuser = DetailUser::create([
            'user_id' => $user_id,
            'foto' =>  '/assets/img/user.png',
            'jabatan_id' => 6
        ]);

        // Tambahkan Notifikasi
        $notifikasi = Notification::create([
            'user_id' => $user_id,
            'judul' => "Anggota Baru",
            'isi' => "Anggota baru \"".$request->nama."\" telah mendaftar. Cek sekarang!"
        ]);

        event(new ContentNotification("Anggota baru \"".$request->nama."\" telah mendaftar. Cek sekarang!", $user_id));

        return response()->json([
            'error' => false,
            'message' => 'Berhasil melakukan registrasi. Silahkan Login.',
            'data' => null
        ]);
    }

    public function complete_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bukti_kesanggupan' => 'required|file|mimes:jpg,png,jpeg,pdf|max:5048',
            'bukti_mahasiswa' => 'required|file|mimes:jpg,png,jpeg,pdf|max:5048',
            'alamat' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'file' => ':attribute harus berupa file.',
            'mimes' => 'File :attribute harus berformat jpg, jpeg, png, atau pdf.',
            'max' => 'File :attribute tidak boleh lebih dari :max KB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => Str::ucfirst($validator->errors()->first()),
                'data' => null
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

            $pathKesanggupan = Storage::putFileAs('public/document/user/bukti-kesanggupan', $request->bukti_kesanggupan, $namaKesanggupan.".".$ekstensiKesanggupan);
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

            $pathBuktiMahasiswa = Storage::putFileAs('public/document/user/bukti-mahasiswa', $request->bukti_mahasiswa, $namaBuktiMahasiswa.".".$ekstensiBuktiMahasiswa);
            // End Upload File

            $detailuser->update([
                'bukti_mahasiswa' => Storage::url($pathBuktiMahasiswa),
            ]);
        }

        if (!empty($request->alamat)) {
            User::findOrFail(Auth::user()->id)->update(['alamat'=>$request->alamat]);
        }

         // Tambahkan Notifikasi
         $user = User::findOrFail($detailuser->id);
         $notifikasi = Notification::create([
            'user_id' => $detailuser->id,
            'judul' => "Telah Melengkapi Profile",
            'isi' => "Anggota baru \"".$user->nama."\" telah melengkapi profilenya. Cek sekarang!"
        ]);

        event(new ContentNotification("Anggota baru \"".$user->nama."\" telah melengkapi profilenya. Cek sekarang!", $detailuser->id));

        return response()->json([
            'error' => false,
            'message' => 'Berhasil melengkapi profil.',
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
