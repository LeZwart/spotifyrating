<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ArtistController extends Controller
{
    private $client;
    function __construct() {
        $this->client = new Client();
    }

    function getAccessToken() {
        // dd(env('SPOTIFY_CLIENT_ID'));
        $response = $this->client->post('https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ]
        ]);

        return json_decode($response->getBody()->getContents())->access_token;
    }



    function index(Request $request) {
        $request->validate([
            'q' => 'nullable|string',
        ]);

        $query = $request->input('q');
        $spotifyApiUrl = 'https://api.spotify.com/v1/search';

        $params = [
            'q' => 'artist:' . $query,
            'type' => 'artist'
        ];

        $searchQuery = http_build_query($params);
        $response = $this->client->request('GET', "$spotifyApiUrl?$searchQuery", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
        ]);

        $artists = json_decode($response->getBody()->getContents())->artists->items;

        return view('artists.index', compact('artists'));
    }



    function show($id) {
        return view('artists.show', ['id' => $id]);
    }
}
