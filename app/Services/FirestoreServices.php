<?php

namespace App\Services;

use Google\Cloud\Firestore\FirestoreClient;

class FirestoreServices
{
    protected $firestore;

    public function __construct(FirestoreClient $firestore)
    {
        $this->firestore = $firestore;
    }

    public function addUser(array $data)
    {
        return $this->firestore
            ->collection('users')
            ->document($data['uid'])
            ->set($data);
    } //MENAMBAHKAN USER

    public function getUser($uid)
    {
        return $this->firestore
            ->collection('users')
            ->document($uid)
            ->snapshot()
            ->data(); 
    } //MENGAMBIL DATA USER YANG SEDANG LOGIN

    public function getAllUsers()
    {
        $documents = $this->firestore
            ->collection('users')
            ->documents();
    
        $data = [];
        foreach ($documents as $document) {
            if ($document->exists()) {
                $item = $document->data();
                $item['id'] = $document->id(); // simpan id dokumen juga
                $data[] = $item;
            }
        }

        return $data;
    } //MENGAMBIL SEMUA USERS (DALAM HAL INI SEMUA JABATAN DIAMBIL)


    public function getUsersByField($field, $value)
    {
        $documents = $this->firestore
            ->collection('users')
            ->documents();

        $data = [];
        foreach ($documents as $document) {
            if ($document->exists()) {
                $item = $document->data();
                $item['id'] = $document->id();

                if (isset($item[$field]) && $item[$field] === $value) {
                    $data[] = $item;
                }
            }
        }

        return $data;
    }


    public function addSurat(array $data)
    {
        return $this->firestore
            ->collection('surat')
            ->document($data['suratUID'])
            ->set($data);
    }

    public function getSurat($uid)
    {
        $documents = $this->firestore
            ->collection('surat')
            ->where('pembuatId', '=', $uid)
            ->documents();

        $result = [];
        foreach ($documents as $doc) {
            if ($doc->exists()) {
                $result[$doc->id()] = $doc->data();
            }
        }

        return $result;
    }
    
    public function cekRTRWExist($tipe, $nomor, $periodeMulai, $periodeAkhir)
    {
        $collection = $this->firestore->collection($tipe)->documents();

        foreach ($collection as $doc) {
            if (!$doc->exists()) continue;

            $data = $doc->data();
            $mulai = $data['periode_mulai'] ?? null;
            $akhir = $data['periode_akhir'] ?? null;

            if (
                isset($data['nomor_' . $tipe]) &&
                $data['nomor_' . $tipe] == $nomor &&
                $mulai <= $periodeAkhir &&
                $akhir >= $periodeMulai
            ) {
                return [
                    'exists' => true,
                    'doc_id' => $doc->id(),
                    'data' => $data
                ];
            }
        }

        return ['exists' => false];
    }

    public function simpanRt(array $data)
    {
        return $this->firestore->collection('rt')->add($data);
    }

    public function simpanRw(array $data)
    {
        return $this->firestore->collection('rw')->add($data);
    }

    public function hapusRTRW($tipe, $docId)
    {
        return $this->firestore->collection($tipe)->document($docId)->delete();
    }

    public function tambahRiwayatRTRW(array $data)
    {
        $id = uniqid('riwayat_');
        return $this->firestore->collection('riwayatRTRW')->document($id)->set($data);
    }


    public function collection($name)
    {
        return $this->firestore->collection($name);
    }

    public function getCollectionData($collection)
    {
        $documents = $this->firestore
            ->collection($collection)
            ->documents();
    
        $data = [];
        foreach ($documents as $document) {
            if ($document->exists()) {
                $item = $document->data();
                $item['id'] = $document->id(); // simpan id dokumen juga
                $data[] = $item;
            }
        }

        return $data;
    }

}
