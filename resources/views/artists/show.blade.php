<x-app-layout>

    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        const artistId = @json($artist->id);
        const csrfToken = "{{ csrf_token() }}";
    </script>


    <div class="max-w-3xl mx-auto mt-16 bg-white shadow-xl rounded-lg text-gray-900">
        <!-- Cover Image Section -->
        <div class="rounded-t-lg h-32 overflow-hidden">
            <img class="object-cover object-top w-full" src="{{ asset('images/background1.png') }}"
                alt="{{ $artist->name }}">
        </div>

        <!-- Profile Image Section -->
        <div class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white rounded-full overflow-hidden">
            @if (!empty($artist->images))
                @foreach ($artist->images as $image)
                    <img src="{{ $image->url }}" alt="{{ $artist->name }}"
                        class="object-cover object-center w-full h-full">
                @endforeach
            @endif
        </div>

        <!-- Artist Name and Genre -->
        <div class="text-center mt-2">
            <h2 class="font-semibold text-xl">{{ $artist->name }}</h2>
            <p class="text-gray-500">{{ implode(', ', $artist->genres) }}</p>
        </div>

        <!-- Stats Section -->
        <ul class="py-4 mt-2 text-gray-700 flex items-center justify-around">
            <li class="flex flex-col items-center justify-around">
                <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                </svg>
                <div>{{ $artist->popularity }} / 100</div>
            </li>
            <li class="flex flex-col items-center justify-between">
                <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z" />
                </svg>
                <div>{{ number_format($artist->followers->total) }}</div>
            </li>
        </ul>

        <!-- Rating and Comment Section -->
        <div class="p-4 border-t mx-8 mt-2">
            <!-- Custom Rating Icon -->
            <div class="mb-4">
                <CustomRatingIcon />
            </div>
            <div id="rating-container"></div>
            <!-- Comment Field -->
            <textarea id="comment" placeholder="Leave a comment..." class="w-full border rounded-lg p-2 mt-2 text-gray-900"></textarea>

            <!-- Follow Button -->
            <button
                class="w-1/2 block mx-auto rounded-full bg-gray-900 hover:shadow-lg font-semibold text-white px-6 py-2 mt-4">
                Follow {{ $artist->name }}
            </button>
        </div>
    </div>
</x-app-layout>
