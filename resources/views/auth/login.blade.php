<x-app-layout>
    <div id="authPage" class="auth-background h-screen flex items-center justify-center">
        <div class="bg-gray-900 bg-opacity-80 p-8 rounded-lg shadow-lg w-full max-w-md text-white">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="text-2xl font-bold mb-4">LOGIN</h1>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-800 text-white" type="email"
                        name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-800 text-white" type="password"
                        name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
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
