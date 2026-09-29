<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CENADI-Douala | Accueil</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-cenadi.jpg') }}">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body { font-family: 'Nunito', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-slate-100 text-slate-900">
        <!-- HEADER EN VERT -->
        <header class="bg-green-600 text-white shadow-md fixed top-0 w-full z-50">
            <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-cenadi.jpg') }}" alt="Logo CENADI" class="h-10 w-auto object-contain rounded bg-white p-0.5">
                    <span class="text-sm font-bold tracking-wider uppercase">CENADI-Douala | SIG-Projet</span>
                </div>
                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/home') }}" class="text-sm font-bold text-white underline">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-white underline">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-bold text-white underline">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </header>

        <div class="relative flex items-top justify-center min-h-screen pt-24 bg-slate-100 sm:items-center py-4">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img src="{{ asset('images/logo-cenadi.jpg') }}" alt="CENADI Logo" class="h-16 w-auto object-contain shadow rounded">
                </div>

                <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg border border-slate-300">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="ml-4 text-lg font-bold text-slate-900"><a href="https://laravel.com/docs" class="underline">Documentation</a></div>
                            </div>
                            <div class="ml-12 mt-2 text-slate-800 text-sm font-medium">
                                Laravel has wonderful, thorough documentation covering every aspect of the framework.
                            </div>
                        </div>
                        <div class="p-6 border-t border-slate-200 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <div class="ml-4 text-lg font-bold text-slate-900"><a href="https://laracasts.com" class="underline">Laracasts</a></div>
                            </div>
                            <div class="ml-12 mt-2 text-slate-800 text-sm font-medium">
                                Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
