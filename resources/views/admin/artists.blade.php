<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Artist management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded w-24 inline-block text-center mb-4">Back</a>

            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <table class="min-w-full divide-y divide-gray-400">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Average Rating</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Total ratings</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Followers</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Popularity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Date Cached</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Last Updated</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-400">
                        @foreach ($artists as $artist)
                            <tr class="hover:bg-gray-700 cursor-pointer" onclick="window.location='{{ route('artists.show', $artist->spotify_id) }}'">
                                <td class="px-6 py-2 text-gray-50">{{ $artist->name }}</td>
                                <td class="px-6 py-2 text-gray-50">{{ round($artist->ratings->avg('rating')) }}</td>
                                <td class="px-6 py-2 text-gray-50">{{ count($artist->ratings) }}</td>
                                <td class="px-6 py-2 text-gray-50">{{ number_format($artist->followers) }}</td>
                                <td class="px-6 py-2 text-gray-50">
                                    <span class="inline-block w-4 h-4 rounded-full" style="background-color: hsl({{ $artist->popularity * 1.5 }}, 100%, 50%);"></span>
                                </td>
                                <td class="px-6 py-2 text-gray-50">{{ $artist->created_at->format('d-m-Y') }}</td>
                                <td class="px-6 py-2 text-gray-50">{{ $artist->updated_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
