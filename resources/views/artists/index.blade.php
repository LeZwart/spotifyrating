<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-100 leading-tight">
            {{ __('Artists') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto bg-[#121212] min-h-screen text-gray-200">

        <!-- Search Form -->
        <form action="{{ route('artists.index') }}" method="get" class="flex items-center mb-8">
            <input type="text" name="q" placeholder="Search artists"
                class="border border-gray-700 rounded-l p-3 w-full text-gray-100 bg-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500">
            <button type="submit"
                class="bg-green-500 text-white p-3 rounded-r hover:bg-green-600 transition duration-300">
                Search
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($artists as $artist)
                <div
                    class="w-full max-w-sm relative bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 transform transition duration-300 hover:scale-105 overflow-hidden">

                    <!-- Blurred Background Image -->
                    @if (isset($artist->images[2]))
                        <div class="absolute inset-0 bg-cover bg-center blur-3xl opacity-100 brightness-50"
                            style="background-image: url('{{ $artist->images[2]->url }}');"></div>
                    @else
                        <div class="absolute inset-0 bg-gray-300 blur-3xl opacity-100 brightness-50"></div>
                    @endif

                    <!-- Foreground Content with Overlay for Readability -->
                    <div class="relative z-10 p-4">
                        <div class="flex justify-end">
                            <button id="dropdownButton{{ $artist->spotify_id }}"
                                data-dropdown-toggle="dropdown{{ $artist->spotify_id }}"
                                class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
                                type="button">
                                <span class="sr-only">Open dropdown</span>
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 16 3">
                                    <path
                                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                </svg>
                            </button>
                            <div id="dropdown{{ $artist->spotify_id }}"
                                class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                <ul class="py-2">
                                    <li><a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                                    </li>
                                    <li><a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export
                                            Data</a></li>
                                    <li><a href="#"
                                            class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Artist Info -->
                        <div class="flex flex-col items-center pb-10">
                            @if (isset($artist->images[2]))
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg object-cover z-20"
                                    src="{{ $artist->images[2]->url }}" alt="{{ $artist->name }} image" />
                            @else
                                <div
                                    class="w-24 h-24 mb-3 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm z-20">
                                    No Image
                                </div>
                            @endif
                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $artist->name }}</h5>
                            <span
                                class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($artist->followers) }}
                                followers</span>
                            <div class="flex mt-4">
                                <a href="{{ route('artists.show', $artist->spotify_id) }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-lg hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">View
                                    Artist</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

</x-app-layout>
