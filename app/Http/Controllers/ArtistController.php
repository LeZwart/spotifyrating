<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpotifySearchRequest;
use App\Services\SpotifyService;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    protected $spotifyService;

    // Inject SpotifyService
    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function index(SpotifySearchRequest $request)
    {
        $request->validated();
        $query = $request->input('q');

        $artists = $this->spotifyService->searchArtists($query);
        return view('artists.index', compact('artists'));
    }

    public function show($id)
    {
        $artist = $this->spotifyService->getArtist($id);
        return view('artists.show', compact('artist'));
    }
}
