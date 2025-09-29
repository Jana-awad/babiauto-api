<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

class FirebaseService
{
    protected $credentials;
    protected $client;

    public function __construct()
    {
        $this->credentials = new ServiceAccountCredentials(
            null,
            [
                'keyFile' => storage_path('firebase/firebase-service-account.json'),
                'scopes' => ['https://www.googleapis.com/auth/firebase.messaging'],
            ]
        );

        $this->client = new Client();
    }

    public function sendNotification($deviceToken, $title, $body)
    {
        $accessToken = $this->credentials->fetchAuthToken()['access_token'];
        $projectId = env('FIREBASE_PROJECT_ID');

        $response = $this->client->post(
            "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send",
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json',
                ],
                'body' => json_encode([
                    'message' => [
                        'token' => $deviceToken,
                        'notification' => [
                            'title' => $title,
                            'body' => $body,
                        ],
                    ],
                ]),
            ]
        );

        return json_decode($response->getBody(), true);
    }
}
