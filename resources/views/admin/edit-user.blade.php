<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('User management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="mt-1 block w-full bg-gray-700 text-gray-300 border-gray-600 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="mt-1 block w-full bg-gray-700 text-gray-300 border-gray-600 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="is_admin" class="block text-sm font-medium text-gray-300">Admin</label>
                        <input type="checkbox" name="is_admin" id="is_admin" {{ $user->role == 'admin' ? 'checked' : '' }} class="mt-1 bg-gray-700 text-gray-300 border-gray-600 rounded-md shadow-sm">
                    </div>

                    <div class="flex items-center justify-start">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md shadow-sm hover:bg-green-700">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
