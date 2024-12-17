<?php

namespace App\Services;

use App\Models\Artist;
use GuzzleHttp\Client;

class SpotifyService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Get Spotify access token
     */
    private function _getAccessToken()
    {
        // Request access token from Spotify using client id and secret
        $response = $this->client->post('https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ]
        ]);

        // Return access token
        return json_decode($response->getBody()->getContents())->access_token;
    }

    /**
     * Search for artists from Spotify
     */
    public function searchArtistsSpotify($query)
    {
        $spotifyApiUrl = 'https://api.spotify.com/v1/search';
        $params = [
            'q' => 'artist:' . $query,
            'type' => 'artist',
        ];

        // turn the params into a query string for the request
        $searchQuery = http_build_query($params);

        // make the request to the Spotify API
        $response = $this->client->request('GET', "$spotifyApiUrl?$searchQuery", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->_getAccessToken(),
            ],
        ]);

        // get the response from the request
        $response = json_decode($response->getBody()->getContents())->artists->items;

        // check if artists are cached in database
        // if not, add them to the database
        $artists = [];
        foreach ($response as $artist) {
            if (!$this->getArtistCached($artist->id)) {
                $createdArtist = $this->_createArtist($artist);
                array_push($artists, $createdArtist);
            } else {
                $cachedArtist = $this->getArtistCached($artist->id);
                $this->_updateArtist($cachedArtist);
                array_push($artists, $cachedArtist);
            }
        }

        // return the artists
        return $artists;
    }

    /**
     * Get artist details from Spotify
     */
    public function getArtistSpotify($spotify_id)
    {
        // make the request to the Spotify API
        $response = $this->client->request('GET', "https://api.spotify.com/v1/artists/" . $spotify_id, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->_getAccessToken(),
            ],
        ]);

        // get the response from the request
        $response = json_decode($response->getBody()->getContents());

        // return the response
        return $response;
    }

    /**
     * Search for artists cached in database using LIKE
     * (does not get sanitized in method, should be done before calling)
     */
    public function searchArtistsCached($query)
    {
        // search for artists in the database
        $artists = Artist::where('name', 'LIKE', '%' . $query . '%')->get();
        return $artists;
    }

    /**
     * Get artist details cached in database
     * (does not get sanitized in method, should be done before calling)
     */
    public function getArtistCached($spotify_id)
    {
        // get artist from the database
        $artist = Artist::all()->where('spotify_id', $spotify_id)->first();
        return $artist;
    }

    /**
     * Update artist in database
     */
    private function _updateArtist($artist)
    {
        // if artist was updated more than 24 hours ago, update it
        if ($artist->updated_at->diffInHours(now()) > 24) {

            // get updated artist details from Spotify
            $artistSpotify = $this->getArtistSpotify($artist->spotify_id);

            // update artist details
            $artist->update([
                'name' => $artistSpotify->name,
                'popularity' => $artistSpotify->popularity,
                'href' => $artistSpotify->href,
                'uri' => $artistSpotify->uri,
                'followers' => $artistSpotify->followers->total,
                'external_url' => $artistSpotify->external_urls->spotify,
            ]);

            // delete all genres and images and add new ones
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
    private function _createArtist($artistSpotify)
    {
        $artist = Artist::create([
            'spotify_id' => $artistSpotify->id,
            'name' => $artistSpotify->name,
            'popularity' => $artistSpotify->popularity,
            'href' => $artistSpotify->href,
            'uri' => $artistSpotify->uri,
            'followers' => $artistSpotify->followers->total,
            'external_url' => $artistSpotify->external_urls->spotify,
        ]);

        // for each genre, create a new genre in the database
        foreach ($artistSpotify->genres as $genre) {
            $artist->genres()->create(['genre' => $genre]);
        }

        // for each image, create a new image in the database
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
    public function searchArtists($query)
    {
        // if query is empty, return empty array
        if (strlen($query) < 1) {
            return [];
        }

        // search for artists in the database
        $artists = $this->searchArtistsCached($query);

        // if less than 20 artists are found, search in Spotify
        if (count($artists) < 20) {
            $artists = collect($this->searchArtistsSpotify($query));
        }


        // TODO: Currently sorts by popularity must have sorting options later
        // sort the artists by popularity and take the top 20
        $artists = $artists->take(20)->sortByDesc('popularity');

        // check each artist for any needed updates
        foreach ($artists as $artist) {
            $this->_updateArtist($artist);
        }

        // return the artists
        return $artists;
    }


    public function getArtist($spotify_id)
    {
        // get the artist from the database
        $artist = $this->getArtistCached($spotify_id);

        // if the artist is not in the database, get it from Spotify
        if (!$artist) {

            // get the artist from Spotify and cache it in the database
            $response = $this->getArtistSpotify($spotify_id);
            $this->_createArtist($response);
        } else {

            // Update the artist if it was last updated more than 24 hours ago
            $this->_updateArtist($artist);
        }

        // get the artist from the database
        return $artist;
    }

    public function getRecentlyQueriedArtists() {

        // get the 20 most recently updated artists
        $artists = Artist::orderBy('updated_at', 'desc')->take(20)->get();
        return $artists;
    }

    public function getMostPopularArtists() {
        // get the 20 most popular artists
        $artists = Artist::orderBy('popularity', 'desc')->take(20)->get();
        return $artists;
    }
}
