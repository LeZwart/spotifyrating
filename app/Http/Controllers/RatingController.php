<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Requests\RatingRequest;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(RatingRequest $request)
    {
        $request->validated();
        $artist = Artist::find($request->artist_id);
        if ($request->rating < 1 || $request->rating > 5) {
            return redirect()->route('artists.show', $artist->id)->with('error', 'Rating must be between 1 and 5');
        }

        // Check if the user has already rated the artist
        $rating = Rating::where('artist_id', $artist->id)
            ->where('user_id', Auth::id())
            ->first();

        // Update rating if the user has already rated artist
        if ($rating) {
            $rating->update([
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            return redirect()->route('artists.show', $artist->spotify_id)->with('success', 'Rating updated successfully');
        }

        Rating::create([
            'artist_id' => $artist->id,
            'rating' => $request->rating,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return redirect()->route('artists.show', $artist->spotify_id)->with('success', 'Rating added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RatingRequest $request)
    {
        $request->validated();

        $artist = Artist::find($request->artist_id);
        $rating = Rating::where('artist_id', $artist->id)
            ->where('user_id', Auth::id())
            ->first();

        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('artists.show', $artist->spotify_id)->with('success', 'Rating updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
