<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 shadow-lg sm:rounded-lg p-6">
                <p class="text-gray-300 mb-6 text-center leading-relaxed">
                    Welcome to the Admin Dashboard. Here, you can manage users and view all cached artists in the system. Navigate through the options below to get started.
                </p>

                <nav>
                    <ul class="flex flex-wrap justify-center gap-4">
                        <li class="w-full sm:w-1/3 md:w-1/4 lg:w-1/6">
                            <a href="{{ route('admin.users') }}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-4 rounded shadow-md transition duration-300 ease-in-out block text-center">
                                <i class="fas fa-users mr-2"></i>User Management
                            </a>
                        </li>
                        <li class="w-full sm:w-1/3 md:w-1/4 lg:w-1/6">
                            <a href="{{ route('admin.artists') }}" class="bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-4 rounded shadow-md transition duration-300 ease-in-out block text-center">
                                <i class="fas fa-music mr-2"></i>Artist Management
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</x-app-layout>
