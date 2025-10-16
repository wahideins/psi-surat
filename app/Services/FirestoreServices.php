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
    }

    public function getUser($uid)
    {
        return $this->firestore
            ->collection('users')
            ->document($uid)
            ->snapshot()
            ->data();
    }
}
