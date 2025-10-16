<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Google\Cloud\Firestore\FirestoreClient;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Auth::class, function () {
            $factory = (new Factory)
                ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                ->withProjectId(env('FIREBASE_PROJECT_ID'));

            return $factory->createAuth();
        });

        $this->app->singleton(FirestoreClient::class, function () {
            return new FirestoreClient([
                'keyFilePath' => base_path(env('FIREBASE_CREDENTIALS')),
                'projectId' => env('FIREBASE_PROJECT_ID'),
            ]);
        });
    }

    public function boot() {}
}
