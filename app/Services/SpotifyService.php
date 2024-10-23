<?php

namespace App\Services;

use App\Models\Artist;
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
    private function _getAccessToken() {
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
     * Search for artists from Spotify
     */
    public function searchArtistsSpotify($query) {
        $spotifyApiUrl = 'https://api.spotify.com/v1/search';
        $params = [
            'q' => 'artist:' . $query,
            'type' => 'artist',
        ];

        $searchQuery = http_build_query($params);

        $response = $this->client->request('GET', "$spotifyApiUrl?$searchQuery", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->_getAccessToken(),
            ],
        ]);

        $response = json_decode($response->getBody()->getContents())->artists->items;


        // check if artists are cached in database
        // if not, add them to the database
        $artists = [];
        foreach ($response as $artist) {
            if (!$this->getArtistCached($artist->uri)) {
                $createdArtist = $this->_createArtist($artist);
                array_push($artists, $createdArtist);
            }
        }
        // dd($artists);
        return $artists;
    }

    /**
     * Get artist details from Spotify
     */
    public function getArtistSpotify($artistHref) {

        $response = $this->client->request('GET', $artistHref, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->_getAccessToken(),
            ],
        ]);

        $response = json_decode($response->getBody()->getContents());
        $artist = $this->getArtistCached($response->href);
        if (!$this->getArtistCached($response->href)) {
            $artist = $this->_createArtist($response);
        }

        return $artist;
    }

    /**
     * Search for artists cached in database using LIKE
     * (does not get sanitized in method, should be done before calling)
     */
    public function searchArtistsCached($query) {
        $artists = Artist::where('name', 'LIKE', '%' . $query . '%')->get();
        return $artists;
    }

    /**
     * Get artist details cached in database
     * (does not get sanitized in method, should be done before calling)
     */
    public function getArtistCached($artistHref) {
        $artist = Artist::find($artistHref);
        return $artist;
    }

    /**
     * Update artist in database
     */
    private function _updateArtist($artist) {
        if ($artist->updated_at->diffInHours(now()) > 24) {
            $artistSpotify = $this->getArtistSpotify($artist->id);

            $artist->update([
                'name' => $artistSpotify->name,
                'popularity' => $artistSpotify->popularity,
                'href' => $artistSpotify->href,
                'uri' => $artistSpotify->uri,
                'followers' => $artistSpotify->followers->total,
                'external_url' => $artistSpotify->external_urls->spotify,
            ]);

            $artist->genres()->delete();
            foreach ($artistSpotify->genres as $genre) {
                $artist->genres()->create(['genre' => $genre]);
            }

            $artist->images()->delete();
            foreach ($artistSpotify->images as $image) {
                $artist->images()->create([
                    'url' => $image->url,
                    'width' => $image->width,
                    'height' => $image->height,
                ]);
            }
        }
    }

    /**
     * Create artist in database
     */
    private function _createArtist($artistSpotify) {
        $artist = Artist::create([
            'id' => $artistSpotify->id,
            'name' => $artistSpotify->name,
            'popularity' => $artistSpotify->popularity,
            'href' => $artistSpotify->href,
            'uri' => $artistSpotify->uri,
            'followers' => $artistSpotify->followers->total,
            'external_url' => $artistSpotify->external_urls->spotify,
        ]);

        foreach ($artistSpotify->genres as $genre) {
            $artist->genres()->create(['genre' => $genre]);
        }

        foreach ($artistSpotify->images as $image) {
            $artist->images()->create([
                'url' => $image->url,
                'width' => $image->width,
                'height' => $image->height,
            ]);
        }

        return $artist;
    }

/**
 * Get artists from Spotify and cache in the database
 * Searches for artists in the database first, if not found, searches in Spotify
 * Sorts the results by popularity
 */
public function searchArtists($query) {
    if (strlen($query) < 3) {
        return [];
    }

    $artists = $this->searchArtistsCached($query);

    if (count($artists) <= 20) {
        $artists = collect($this->searchArtistsSpotify($query));
    }

    // TODO: Currently sorts by popularity must have sorting options later
    $artists = $artists->take(20)->sortByDesc('popularity');
    foreach ($artists as $artist) {
        $this->_updateArtist($artist);
    }

    return $artists;
}


    public function getArtist($artistHref) {
        $artist = $this->getArtistCached($artistHref);
        if (!$artist) {
            $artist = $this->getArtistSpotify($artistHref);
        } else {
            $this->_updateArtist($artist);
        }

        return $artist;
    }

}
