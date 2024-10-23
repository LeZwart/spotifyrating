<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <!-- Artist Name -->
        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $artist->name }}</h1>

        <!-- Artist Images -->
        <div class="flex justify-center space-x-4 mb-6">
            @foreach ($artist->images as $image)
                <img src="{{ $image->url }}" alt="{{ $artist->name }}"
                    class="rounded-full h-32 w-32 object-cover shadow-md">
            @endforeach
        </div>

        <!-- Artist Genres -->
        <p class="text-lg text-gray-700 mb-2">
            {{-- <strong>Genres:</strong> {{ implode(', ', $artist->genres) }} --}}
        </p>

        <!-- Artist Popularity -->
        <p class="text-lg text-gray-700 mb-2">
            <strong>Popularity:</strong> {{ $artist->popularity }} / 100
        </p>

        <!-- Artist Followers -->
        <p class="text-lg text-gray-700 mb-6">
            <strong>Followers:</strong> {{ number_format($artist->followers) }}
        </p>

        <!-- Optional Flowbite button for extra interaction -->
        <button class="text-white bg-blue-500 hover:bg-blue-600 font-medium rounded-lg text-sm px-5 py-2.5">
            Follow {{ $artist->name }}
        </button>
    </div>
</x-app-layout>
