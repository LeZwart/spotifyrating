<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Artists') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto">
        <form action="{{ route('artists.index') }}" method="get" class="flex items-center mb-8">
            <input
                type="text"
                name="q"
                placeholder="Search artists"
                class="border rounded-l p-3 w-full text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
            <button
                type="submit"
                class="bg-blue-500 text-white p-3 rounded-r hover:bg-blue-600 transition duration-300"
            >
                Search
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($artists as $artist)
            {{-- @dd($artist) --}}

            {{-- TODO: change href to show route later --}}
            <a href="https://open.spotify.com/artist/{{ $artist->id }}" class="bg-white overflow-hidden shadow-lg hover:shadow-xl sm:rounded-lg p-6 mb-4 transform transition duration-300 hover:scale-105">
                <div class="flex items-center">
                    @if(isset($artist->images[2]))
                        <img src="{{ $artist->images[2]->url }}" alt="Artist Image" class="w-16 h-16 rounded-full mr-4 object-cover">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-200 mr-4 flex items-center justify-center text-gray-500 text-sm">
                            No Image
                        </div>
                    @endif
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $artist->name }}</h2>
                        <p class="text-gray-500">{{ $artist->followers->total }} followers</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
