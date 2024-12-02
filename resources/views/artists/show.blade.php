<x-app-layout>
    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        const artistId = @json($artist->id);
        const csrfToken = "{{ csrf_token() }}";
    </script>

    <div class="max-w-3xl mx-auto mt-16 bg-white shadow-xl rounded-lg text-gray-900">
        <div class="rounded-t-lg h-32 overflow-hidden">
            <img class="object-cover object-top w-full" src="{{ asset('images/background1.png') }}" alt="{{ $artist->name }}">
        </div>

        <div class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white rounded-full overflow-hidden">
            @if (!empty($artist->images))
                @foreach ($artist->images as $image)
                    <img src="{{ $image->url }}" alt="{{ $artist->name }}" class="object-cover object-center w-full h-full">
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
            <button class="mt-4 rounded-full bg-gray-900 hover:shadow-lg font-semibold text-white px-6 py-2">
                Follow {{ $artist->name }}
            </button>
            <br>
            <ul class="flex items-center justify-around w-full max-w-md">
                
                <li class="flex flex-col items-center">
                    <h3>Popularity:</h3>
                    <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                    </svg>
                    <div>{{ $artist->popularity }} / 100</div>
                </li>
                <li class="flex flex-col items-center">
                    <h3>Followers:</h3>
                    <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z" />
                    </svg>
                    <div>{{ number_format($artist->followers) }}</div>
                </li>
            </ul>
            
        </div>

        <!-- Review Section -->
        <div class="p-4 mt-4 text-center">
            <h3 class="text-lg font-bold">Overall Rating</h3>
            <div id="review-display" class="w-full h-20 bg-gray-100 rounded-lg flex items-center justify-center mt-2">
                <!-- Placeholder for rating content -->
                <span class="text-2xl font-semibold text-gray-600">Rating Placeholder</span>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="p-4 border-t mt-4">
            <h3 class="text-lg font-bold mb-2">Comments</h3>
            <textarea id="comment" placeholder="Leave a comment..." class="w-full border rounded-lg p-2 text-gray-900"></textarea>
        </div>
    </div>
</x-app-layout>
