<?php

namespace App\Services;

use GuzzleHttp\Client;

class SpotifyService
{
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    /**
     * Get Spotify access token
     */
    private function getAccessToken() {
        $response = $this->client->post('https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ]
        ]);

        return json_decode($response->getBody()->getContents())->access_token;
    }

    /**
     * Search for artists on Spotify
     */
    public function searchArtists($query) {
        $spotifyApiUrl = 'https://api.spotify.com/v1/search';

        $params = [
            'q' => 'artist:' . $query,
            'type' => 'artist',
        ];

        $searchQuery = http_build_query($params);

        $response = $this->client->request('GET', "$spotifyApiUrl?$searchQuery", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
        ]);

        return json_decode($response->getBody()->getContents())->artists->items;
    }

    /**
     * Get artist details from Spotify
     */
    public function getArtist($artistId) {
        $spotifyApiUrl = "https://api.spotify.com/v1/artists/{$artistId}";

        $response = $this->client->request('GET', $spotifyApiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
