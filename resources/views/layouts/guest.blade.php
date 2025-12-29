<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ENSA Tanger - Authentification</title>

        <!-- Tailwind & Config -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            ensa: {
                                blue: '#004de6',
                                darkBlue: '#002b80',
                                lightBlue: '#e6eeff',
                            }
                        }
                    }
                }
            }
        </script>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="bg-gray-100 text-gray-900 antialiased min-h-screen flex flex-col justify-center items-center p-4">
        
        <div class="w-full max-w-5xl">
            <!-- Logo / Retour accueil -->
            <div class="mb-6 flex justify-center lg:justify-start">
                <a href="/" class="flex items-center gap-2 text-ensa-blue font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour à l'accueil
                </a>
            </div>

            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col lg:flex-row min-h-[600px]">
                {{ $slot }}
            </div>
            
            <p class="text-center text-gray-500 text-xs mt-8 italic">
                &copy; {{ date('Y') }} ENSA Tanger • Département Génie Informatique
            </p>
        </div>
    </body>
</html>