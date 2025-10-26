<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirestoreServices;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class RiwayatSuratController extends Controller
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
        $surat = $this->firestore->getSurat($uid);

        return view('warga.riwayatSurat', compact('surat'));
    }

    public function previewSurat($id)
    {
        $session = Session::get('user');

        if (!$session || empty($session->uid)) {
            return redirect()->route('login')->withErrors('Sesi pengguna tidak ditemukan.');
        }

        $uid = $session->uid;
        $dataSurat = $this->firestore->getSuratById($uid, $id);

        if (!$dataSurat) {
            return redirect()->route('riwayatSurat')->withErrors('Data surat tidak ditemukan.');
        }

        $biodata = $dataSurat['dataPemohon'][0] ?? [];
        $data = [
            'biodata' => $biodata,
            'kategori' => $dataSurat['kategori'] ?? '-',
            'keperluan' => $dataSurat['keperluan'] ?? '-',
            'tanggal' => date('d F Y', strtotime($dataSurat['tanggalPengajuan'] ?? now())),
        ];

        // Simpan sementara agar bisa digunakan saat cetak
        Session::put('preview_surat', $data);

        return view('warga.previewSurat', $data);
    }

    public function cetakSurat($id)
    {
        try {
            $data = Session::get('preview_surat');

            if (!$data) {
                return redirect()->route('riwayatSurat')->withErrors('Tidak ada surat yang bisa dicetak.');
            }

            $html = View::make('warga.previewSurat', $data)->render();
            $path = storage_path('app/public/surat_pengantar_' . $id . '.pdf');

            // Deteksi chrome path secara fleksibel
            $chromePath = '/usr/bin/chromium-browser';
            if (!file_exists($chromePath)) {
                $chromePath = '/usr/bin/chromium';
            }
            if (!file_exists($chromePath)) {
                $chromePath = '/usr/bin/google-chrome';
            }

            Browsershot::html($html)
                ->noSandbox()
                ->setChromePath($chromePath)
                ->showBackground()
                ->format('A4')
                ->margins(20, 10, 20, 10)
                ->save($path);

            return response()->download($path, 'surat_pengantar_' . $id . '.pdf');
        } catch (\Exception $e) {
            Log::error('Gagal mencetak surat: ' . $e->getMessage());
            return redirect()->back()->withErrors('Gagal mencetak surat: ' . $e->getMessage());
        }
    }
}
