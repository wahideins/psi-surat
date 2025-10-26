<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirestoreServices;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\View;

class AjukanSuratController extends Controller
{
    protected $auth;
    protected $firestore;

    public function __construct(FirebaseAuth $auth, FirestoreServices $firestore)
    {
        $this->auth = $auth;
        $this->firestore = $firestore;
    }

    public function tampilkanHalaman()
    {
        $session = Session::get('user');

        if (!$session || empty($session->uid)) {
            return redirect()->route('login')->withErrors('Sesi pengguna tidak ditemukan.');
        }

        $uid = $session->uid;
        $biodata = $this->firestore->getUser($uid);

        return view('warga.ajukanSurat', compact('biodata'));
    }

    public function previewSurat(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required',
            'keperluan' => 'string',
        ]);

        $session = Session::get('user');
        $uid = $session->uid;
        $biodata = $this->firestore->getUser($uid);

        $data = [
            'biodata' => $biodata,
            'kategori' => $validated['kategori'],
            'keperluan' => $validated['keperluan'],
            'tanggal' => now()->translatedFormat('d F Y'),
        ];

        // Simpan data ke session agar bisa dicetak nanti
        Session::put('preview_surat', $data);

        return view('warga.previewSurat', $data);
    }

    public function cetakSurat()
    {
        $data = Session::get('preview_surat');

        if (!$data) {
            return redirect()->route('ajukanSurat')->withErrors('Tidak ada surat yang bisa dicetak.');
        }

        $html = View::make('warga.previewSurat', $data)->render();

        $path = storage_path('app/public/surat_pengantar.pdf');

        Browsershot::html($html)
            ->setChromePath(env('CHROME_PATH', '/usr/bin/chromium-browser'))
            ->format('A4')
            ->margins(20, 10, 20, 10)
            ->showBackground()
            ->save($path);


        return response()->download($path, 'surat_pengantar.pdf');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required',
        ]);

        $session = Session::get('user');
        $uid = $session->uid;
        $biodata = $this->firestore->getUser($uid);
        $suratUID = $biodata['uid'].now()->toDateTimeString();
        // Simpan ke Firestore
        $suratData = [
            'suratUID' => $suratUID,
            'dataPemohon' => [$biodata],
            'kategori' => $validated['kategori'],
            'keperluan' => $request['keperluan'],
            'pembuatId'=> $biodata['uid'],
            'status' => 'menunggu_persetujuan',
            'tanggalPengajuan' => now()->toDateTimeString(),
        ];

        $this->firestore->addSurat($suratData);

        return redirect()->route('ajukanSurat')->with('success', 'Surat Berhasil Dikirim');
    }
}
