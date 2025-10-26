<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirestoreServices;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class KependudukanController extends Controller
{

    protected $auth;
    protected $firestore;

    public function __construct(FirebaseAuth $auth, FirestoreServices $firestore)
    {
        $this->auth = $auth;
        $this->firestore = $firestore;
    }

    public function getWarga()
    {
        // Ambil semua user dari Firestore
        $warga = $this->firestore->getAllUsers();

        // Kirim ke view Blade
        return view('kelurahan.daftarWarga', compact('warga'));
    }

    public function detailWarga($uid)
    {
        $warga = $this->firestore->getUser($uid);

        return view('kelurahan.detailWarga',compact('warga'));
    }

    public function getKepalaKeluarga()
    {
        $kepalaKeluarga = $this->firestore->getUsersByField('statusDiKeluarga', 'Kepala Keluarga');
        
        return view('kelurahan.kepalaKeluarga', compact('kepalaKeluarga'));

    }

    public function getJabatan($field, $value)
    {
        $warga = $this->firestore->getUsersByField($field, $value);
        return view('kelurahan.wargaWithJabatan', compact('warga'));
    }

    public function halamanRT()
    {
        $tanggalSekarang = Carbon::now();
        $dataRT = $this->firestore->getCollectionData('rt');

        // Filter berdasarkan periode aktif
        $rtAktif = collect($dataRT)
            ->filter(function ($item) use ($tanggalSekarang) {
                if (isset($item['periode_mulai']) && isset($item['periode_akhir'])) {
                    try {
                        $mulai = Carbon::parse($item['periode_mulai']);
                        $akhir = Carbon::parse($item['periode_akhir']);

                        return $tanggalSekarang->between($mulai, $akhir);
                    } catch (\Exception $e) {
                        \Log::error('Format tanggal tidak valid: ' . json_encode($item));
                        return false;
                    }
                }
                return false;
            })
            // ✅ Urutkan berdasarkan nomor_rt
            ->sortBy(function ($item) {
                // Pastikan bisa diurutkan secara numerik (bukan string)
                return (int) ($item['nomor_rt'] ?? 0);
            })
            ->values()
            ->all();

        return view('kelurahan.rt', [
            'rtAktif' => $rtAktif,
            'tanggal' => $tanggalSekarang->toDateString(),
        ]);
    }


    public function halamanRW()
    {
        $tanggalSekarang = Carbon::now();
        $dataRT = $this->firestore->getCollectionData('rw');

        // Filter berdasarkan periode aktif
        $rtAktif = collect($dataRT)
            ->filter(function ($item) use ($tanggalSekarang) {
                if (isset($item['periode_mulai']) && isset($item['periode_akhir'])) {
                    try {
                        $mulai = Carbon::parse($item['periode_mulai']);
                        $akhir = Carbon::parse($item['periode_akhir']);

                        return $tanggalSekarang->between($mulai, $akhir);
                    } catch (\Exception $e) {
                        \Log::error('Format tanggal tidak valid: ' . json_encode($item));
                        return false;
                    }
                }
                return false;
            })
            // ✅ Urutkan berdasarkan nomor_rt
            ->sortBy(function ($item) {
                // Pastikan bisa diurutkan secara numerik (bukan string)
                return (int) ($item['nomor_rw'] ?? 0);
            })
            ->values()
            ->all();

        return view('kelurahan.rw', [
            'rtAktif' => $rtAktif,
            'tanggal' => $tanggalSekarang->toDateString(),
        ]);
    }



}
