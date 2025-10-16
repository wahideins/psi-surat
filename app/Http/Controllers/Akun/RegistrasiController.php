<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use App\Services\FirestoreServices;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RegistrasiController extends Controller
{
    protected $auth;
    protected $firestore;

    public function __construct(FirebaseAuth $auth, FirestoreServices $firestore)
    {
        $this->auth = $auth;
        $this->firestore = $firestore;
    }

    public function tampilkanForm()
    {
        return view('auth.register');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|string|max:50',
            'no_hp' => 'required|string|max:20',
            'status_perkawinan' => 'required|string|max:50',
            'status_dalam_keluarga' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'nama_jalan' => 'required|string|max:150',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'rt' => 'required|integer|max:37',
            'rw' => 'required|integer|max:10',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'foto_ktp' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan foto KTP ke storage publik
        if ($request->hasFile('foto_ktp')) { 
            $path = $request->file('foto_ktp')->store('ktp', 'public'); 
            $validated['foto_ktp_url'] = asset('storage/' . $path); 
            unset($validated['foto_ktp']); }

        // Format nomor HP
        if (!str_starts_with($validated['no_hp'], '+62')) {
            $validated['no_hp'] = '+62' . ltrim($validated['no_hp'], '0');
        }

        // Buat user di Firebase Auth
        try {
            // Coba buat user di Firebase Auth
            $firebaseUser = $this->auth->createUser([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);
        } catch (\Kreait\Firebase\Exception\Auth\EmailExists $e) {
            return back()
                ->withErrors(['email' => 'Email sudah terdaftar. Silakan gunakan email lain.'])
                ->withInput();
        } catch (\Kreait\Firebase\Exception\AuthException $e) {
            return back()
                ->withErrors(['firebase' => 'Gagal membuat akun Firebase: ' . $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            // Tangani error tak terduga supaya tidak keluar halaman error Laravel
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }


        // Buat link verifikasi email
        $verifyLink = $this->auth->getEmailVerificationLink($validated['email']);

        // Kirim email verifikasi menggunakan Laravel Mail (opsional)
        try {
            Mail::raw("Silakan verifikasi akun Anda melalui tautan berikut:\n\n$verifyLink", function ($message) use ($validated) {
                $message->to($validated['email'])
                        ->subject('Verifikasi Akun Anda');
            });
        } catch (\Exception $e) {
            // Jangan hentikan proses jika email gagal
            \Log::warning('Gagal mengirim email verifikasi: '.$e->getMessage());
        }


        // Simpan ke Firestore
        $userData = [
            'nik' => $validated['nik'],
            'nama' => $validated['nama'],
            'tempatLahir' => $validated['tempat_lahir'],
            'tanggalLahir' => $validated['tanggal_lahir'],
            'jenisKelamin' => $validated['jenis_kelamin'],
            'kewarganegaraan'=>'NKRI',
            'agama' => $validated['agama'],
            'noHp' => $validated['no_hp'],
            'statusPerkawinan' => $validated['status_perkawinan'],
            'statusDalamKeluarga' => $validated['status_dalam_keluarga'],
            'pekerjaan' => $validated['pekerjaan'],
            'namaJalan' => $validated['nama_jalan'],
            'provinsi' => $validated['provinsi'],
            'kota' => $validated['kota'],
            'kecamatan' => $validated['kecamatan'],
            'kelurahan' => $validated['kelurahan'],
            'rt' => $validated['rt'],
            'rw' => $validated['rw'],
            'email' => $validated['email'],
            'urlFotoKtp' => $validated['foto_ktp_url'],
            'uid' => $firebaseUser->uid,
            'role' => 'warga',
            'createdAt' => now()->toDateTimeString(),
        ];

        $this->firestore->addUser($userData);

        return redirect()->back()->with('success', 'Pendaftaran berhasil! Cek email Anda untuk verifikasi.');
    }
}
