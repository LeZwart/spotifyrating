<x-app-layout>
    <div id="authPage" class="auth-background min-h-screen flex items-center justify-center">
        <form method="POST" action="{{ route('register') }}"
            class="bg-gray-900 bg-opacity-80 p-8 rounded-lg shadow-lg max-w-md w-full text-white">
            @csrf

            <h2 class="text-2xl font-bold mb-6">Register</h2>

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" class="text-gray-400" />
                <x-text-input id="name" class="block w-full mt-1 bg-gray-800 text-white" type="text"
                    name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-gray-400" />
                <x-text-input id="email" class="block w-full mt-1 bg-gray-800 text-white" type="email"
                    name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-400" />
                <x-text-input id="password" class="block w-full mt-1 bg-gray-800 text-white" type="password"
                    name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-400" />
                <x-text-input id="password_confirmation" class="block w-full mt-1 bg-gray-800 text-white"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>

            <!-- Actions: Already Registered & Register Button -->
            <div class="flex items-center justify-between">
                <a class="text-sm text-green-500 hover:underline" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Background script for rotating images -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var backgrounds = [
                'images/Drake.jpg',
                'images/theweeknd.jpg',
                'images/playboi.jpg',
            ];
            var current = 0;

            function nextBackground() {
                current = (current + 1) % backgrounds.length;
                $('#authPage').fadeOut(500, function() {
                    $('#authPage').css('background-image', 'url(' + backgrounds[current] + ')').fadeIn(500);
                });
            }

            $('#authPage').css('background-image', 'url(' + backgrounds[current] + ')');
            setInterval(nextBackground, 5000);
        });
    </script>
</x-app-layout>
