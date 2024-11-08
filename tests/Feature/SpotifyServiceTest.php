<?php

test('SpotifyService can search for artists', function () {
    $spotifyService = new \App\Services\SpotifyService();
    $artists = $spotifyService->searchArtistsSpotify('Metallica');

    $this->assertIsArray($artists);
    $this->assertNotEmpty($artists);
    $this->assertInstanceOf(\App\Models\Artist::class, $artists[0]);
});

test('SpotifyService can cache artists', function () {
    $spotifyService = new \App\Services\SpotifyService();
    $artists = $spotifyService->searchArtistsSpotify('Metallica');

    $this->assertIsArray($artists);
    $this->assertNotEmpty($artists);
    $this->assertInstanceOf(\App\Models\Artist::class, $artists[0]);

    $cachedArtist = $spotifyService->getArtistCached($artists[0]->spotify_id);

    $this->assertNotEmpty($cachedArtist);
    $this->assertInstanceOf(\App\Models\Artist::class, $cachedArtist);

    // Assert must be done as array, because php hates me
    $this->assertEquals($artists[0]->toArray(), $cachedArtist->toArray());
});
