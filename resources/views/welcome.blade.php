<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else

        @endif
    </head>
    <body class="bg-gray-800 text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="absolute top-0 right-0 p-6">
                    @auth
                        <!-- Removed the Dashboard link -->
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 text-white bg-[#6C63FF] hover:bg-[#5a52cc] border rounded-sm text-sm leading-normal shadow-md"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 text-white bg-[#6C63FF] hover:bg-[#5a52cc] border rounded-sm text-sm leading-normal shadow-md">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
        <div id="app">
            <personal-diary-card></personal-diary-card>
        </div>
    </body>
</html>
