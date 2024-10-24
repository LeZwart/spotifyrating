<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpotifySearchRequest;
use App\Services\SpotifyService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function show($spotify_id)
    {
        $artist = $this->spotifyService->getArtist($spotify_id);
        return view('artists.show', compact('artist'));
    }

    public function showHomepage()
    {
        // Example array of artist IDs, you can modify this as needed
        $artistIds = [
            '1Xyo4u8uXC1ZmMpatF05PJ', // Drake
            '1URnnhqYAYcrqrcwql10ft', // 21 Savage
            '4O15NlyKLIASxsJ0PrXPfz', // Juice WRLD
            '1MCJ4DBW9kuMSS4M9WhCMG'  // Playboi Carti (replace with actual ID)
        ];

        $images = [];

        foreach ($artistIds as $id) {
            $response = Http::withToken('YOUR_SPOTIFY_ACCESS_TOKEN')->get("https://api.spotify.com/v1/artists/{$id}");

            if ($response->successful()) {
                $artistData = $response->json();
                // Add the artist's image URL to the images array
                if (!empty($artistData['images'])) {
                    $images[] = $artistData['images'][0]['url']; // Get the first image
                }
                // } else {
                //     // Handle the error (optional)
                //     Log::error("Error fetching artist data: " . $response->body());
                // }
            }

            return view('homepage', ['backgroundImages' => $images]);
        }
    }
}
