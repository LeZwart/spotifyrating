<x-app-layout>
    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        const artistId = @json($artist->id);
        const csrfToken = "{{ csrf_token() }}";
    </script>

    <div class="max-w-3xl mx-auto mt-16 bg-white shadow-xl rounded-lg text-gray-900">
        <div class="rounded-t-lg h-32 overflow-hidden">
            <img class="object-cover object-top w-full" src="{{ asset('images/background1.png') }}"
                alt="{{ $artist->name }}">
        </div>

        <div class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white rounded-full overflow-hidden">
            @if (!empty($artist->images))
                @foreach ($artist->images as $image)
                    <img src="{{ $image->url }}" alt="{{ $artist->name }}"
                        class="object-cover object-center w-full h-full">
                @endforeach
            @endif
        </div>
        <div class="text-center mt-2">
            <h2 class="font-semibold text-xl">{{ $artist->name }}</h2>
            @foreach ($artist->genres as $genre)
                <span class="text-sm text-gray-500">{{ $genre->genre }},</span>
            @endforeach
        </div>
        <div class="py-4 mt-4 flex flex-col items-center text-gray-700">
            <a href="https://open.spotify.com/artist/{{ $artist->spotify_id }}" class="mb-4 rounded-full bg-gray-900 hover:shadow-lg font-semibold text-white px-6 py-2">
                {{ $artist->name }} on Spotify
            </a>
            <br>
            <ul class="flex items-center justify-around w-full max-w-md">

                <li class="flex flex-col items-center">
                    <h3>Popularity:</h3>
                    <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                    </svg>
                    <div>{{ $artist->popularity }} / 100</div>
                </li>
                <li class="flex flex-col items-center">
                    <h3>Followers:</h3>
                    <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z" />
                    </svg>
                    <div>{{ number_format($artist->followers) }}</div>
                </li>
            </ul>

        </div>

        <!-- Review Section -->
        <div class="p-4 mt-4 text-center">
            <h3 class="text-lg font-bold">Overall Rating</h3>
            <div id="review-display" class="w-full h-20 bg-gray-100 rounded-lg flex items-center justify-center mt-2">
                @php
                    $averageRating = round($artist->ratings->avg('rating'), 1);
                @endphp

                <div class="flex items-center justify-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 @if ($i <= $averageRating) text-yellow-500 @else text-gray-300 @endif"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.784.57-1.838-.197-1.54-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.05 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                        </svg>
                    @endfor
                    <span class="ml-2 text-gray-600">{{ $averageRating }} / 5</span>
                </div>
            </div>
        </div>

        @auth()

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block">{{ session('error') }}</span>
            </div>
        @endif
        <form class="p-6 border rounded-lg shadow-lg mt-6 bg-white" method="POST" action="{{ route('artist.rating.store', $artist->id) }}">
            @csrf
            <h3 class="text-xl font-bold mb-4 text-gray-800">Leave a Rating</h3>

            <!-- Rating -->
            <div id="rating" class="flex gap-2 mb-4">
                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-8 h-8 cursor-pointer transition-all duration-200 ease-in-out
                                @if ($i <= $artist->rating) text-yellow-500 @else text-gray-300 @endif"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        data-value="{{ $i }}">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.784.57-1.838-.197-1.54-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.05 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                    </svg>
                @endfor
                <input type="hidden" name="rating" id="rating-value" value="{{ $artist->rating }}">
            </div>

            <!-- Comment -->
            <textarea id="comment" name="comment" placeholder="Leave a comment..."
                class="w-full border-gray-300 rounded-lg p-4 text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
                rows="4"></textarea>

            <!-- Submit Button -->
            <input type="hidden" name="artist_id" value="{{ $artist->id }}">
            <button type="submit"
                class="mt-4 rounded-full bg-gray-900 hover:shadow-lg text-white font-semibold px-6 py-3 transition-all duration-200">
                Send Rating
            </button>
        </form>
        <script>
            document.querySelectorAll('#rating svg').forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-value');
                    document.getElementById('rating-value').value = rating;

                    // Update the star colors
                    document.querySelectorAll('#rating svg').forEach(s => {
                        if (s.getAttribute('data-value') <= rating) {
                            s.classList.add('text-yellow-500');
                            s.classList.remove('text-gray-300');
                        } else {
                            s.classList.add('text-gray-300');
                            s.classList.remove('text-yellow-500');
                        }
                    });
                });
            });
        </script>
        @endauth

        @guest
            <div class="p-4 mt-4 text-center">
                <p class="text-gray-700"><a href="{{ route('login') }}" class="text-green-500">log in</a> to leave a rating.</p>
            </div>
        @endguest
        @foreach ($artist->ratings as $rating)
        <div class="mt-4 p-4 border rounded-lg shadow-lg bg-white">
            <div class="flex items-center mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-6 h-6 @if ($i <= $rating->rating) text-yellow-500 @else text-gray-300 @endif"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.784.57-1.838-.197-1.54-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.05 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                    </svg>
                @endfor
            </div>
            <p class="text-gray-700">{{ $rating->comment }}</p>
            <p class="text-sm text-gray-500 mt-2">By {{ $rating->user->name }}</p>
        </div>
        @endforeach

    </div>
</x-app-layout>
