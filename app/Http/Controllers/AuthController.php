<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $user = User::create($request->all());

        $user_id = $user->id;

        $detailuser = DetailUser::create([
            'user_id' => $user_id,
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
        # code...
    }


}
