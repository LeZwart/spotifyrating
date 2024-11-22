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

        // Check if the user has already rated the artist
        $rating = Rating::where('artist_id', $artist->id)
            ->where('user_id', Auth::id())
            ->first();

        // If the user has already rated the artist, redirect back with an error message
        if ($rating) {
            return redirect()->route('artists.show', $artist->id)->with('error', 'You have already rated this artist');
        }

        Rating::create([
            'artist_id' => $artist->id,
            'rating' => $request->rating,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return redirect()->route('artists.show', $artist->id)->with('success', 'Rating added successfully');
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

        return redirect()->route('artists.show', $artist->id)->with('success', 'Rating updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
