<x-app-layout>
    <div id="homePage"
        class="font-nerko w-screen h-screen overflow-hidden relative before:block before:absolute before:bg-black before:h-full before:w-full before:top-0 before:left-0 before:z-10 before:opacity-30 bg-cover bg-center transition-all duration-1000 ease-linear">

        <div class="relative z-20 max-w-screen-lg mx-auto grid grid-cols-12 h-full items-center">
            <div class="col-span-6 flex flex-col justify-center"> <!-- Centering the content -->
                <span class="uppercase text-white text-xs font-bold mb-2 block">Search your favorite artist and rate
                    him!</span>
                <h1 class="text-white font-extrabold text-5xl mb-8">Who is your favorite artist?</h1>

                <form action="{{ route('artists.index') }}" method="GET" class="w-[600px] mx-auto bg-gray-800">
                    <!-- Set form width explicitly -->
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="q" name="q"
                            class="block w-[450px] p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search Artists..." required />
                        <button type="submit"
                            class="absolute right-8 bottom-2.5 bg-gray-800 hover:bg-[#A8D13E] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var backgrounds = [
                // 'images/21savage.jpg',
                'images/Drake.jpg',
                'images/theweeknd.jpg',
                'images/playboi.jpg',
            ];

            var current = 0;

            function nextBackground() {
                // Use modulus to cycle through images
                current = (current + 1) % backgrounds.length;

                // Fade out, change the image, then fade back in
                $('#homePage').fadeOut(500, function() {
                    // Set the new background image
                    $('#homePage').css('background-image', 'url(' + backgrounds[current] + ')').fadeIn(500);
                });
            }

            // Set the initial background image
            $('#homePage').css('background-image', 'url(' + backgrounds[current] + ')');
            // Change background every 5 seconds
            setInterval(nextBackground, 5000);
        });
    </script>


</x-app-layout>
