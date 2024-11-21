<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('User management') }}
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Role</th>

                            {{-- buttons --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-100 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-400">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-50">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-50">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-50">
                                    {{ $user->role == 'admin' ? 'Admin' : 'User' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-50">
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('This action will delete {{ $user->name }} and cannot be undone. Are you sure?')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-24">Delete</button>
                                    </form>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-24 inline-block text-center">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
