<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                <p class="text-gray-300 mb-4 w-1/2 mx-auto">
                    In the Admin Dashboard, you can manage users by editing their details and permissions. Additionally, you can view all cached artists to keep track of the artists in the system.
                </p>

                <nav>
                    <ul class="flex flex-wrap justify-center">
                        <li class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 p-2">
                            <a href="{{ route('admin.users') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded w-full block text-center">
                                User management
                            </a>
                        </li>
                        <li class="w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/6 p-2">
                            <a href="{{ route('admin.artists') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded w-full block text-center">
                                Artist management
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</x-app-layout>
