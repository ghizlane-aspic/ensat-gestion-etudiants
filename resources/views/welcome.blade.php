<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ENSA Tanger - Gestion des Étudiants</title>

        <!-- Chargement forcé de Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <script>
            tailwind.config = {
                darkMode: 'class',
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
    <body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
        
        <!-- Navigation -->
        <nav class="w-full max-w-7xl mx-auto px-6 py-4 flex justify-end gap-4 text-sm font-medium">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-ensa-blue border border-ensa-blue/20 px-4 py-2 rounded hover:bg-ensa-blue hover:text-white transition">Tableau de Bord</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 px-4 py-2 hover:text-ensa-blue">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-ensa-blue text-white px-5 py-2 rounded shadow-md hover:bg-ensa-darkBlue transition">S'inscrire</a>
                    @endif
                @endauth
            @endif
        </nav>

        <!-- Contenu Principal -->
        <main class="flex-grow flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden flex flex-col lg:flex-row">
                
                <!-- Côté Gauche : Texte -->
                <div class="flex-1 p-8 lg:p-16">
                    <div class="mb-6">
                        <p class="text-ensa-blue font-bold tracking-widest uppercase text-xs mb-2">Université Abdelmalek Essaâdi</p>
                        <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                            Gestion des Étudiants <br>
                            <span class="text-ensa-blue">ENSA Tanger</span>
                        </h1>
                        <div class="h-1.5 w-20 bg-ensa-blue mt-4 rounded-full"></div>
                    </div>

                    <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                        Plateforme numérique dédiée au suivi académique, à la gestion des modules et aux services aux étudiants de l'École Nationale des Sciences Appliquées de Tanger.
                    </p>



                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('login') }}" class="bg-ensa-blue text-white px-10 py-4 rounded-xl font-bold hover:bg-ensa-darkBlue transition-all shadow-lg hover:shadow-ensa-blue/30">
                            Accéder au Portail
                        </a>

                    </div>
                </div>

                <!-- Côté Droit : Logo / Visuel -->
                <div class="bg-ensa-blue lg:w-96 flex flex-col items-center justify-center p-12 text-white relative overflow-hidden">
                    <!-- Cercle décoratif en fond -->
                    <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-ensa-darkBlue rounded-full opacity-50"></div>
                    
                    <!-- Logo ENSA Tanger -->
                    <div class="relative z-10 bg-white p-8 rounded-3xl shadow-2xl mb-8 transform hover:scale-105 transition-transform duration-300">
                        <div class="text-ensa-blue text-center">
                            <!-- Logo en texte stylisé pour correspondre au logo réel -->
                            <span class="text-5xl font-black block leading-none">ENSA</span>
                            <div class="h-1 bg-ensa-blue w-full my-1"></div>
                            <span class="text-xl font-bold block tracking-[0.2em]">TANGER</span>
                        </div>
                    </div>

                    <div class="relative z-10 text-center">
                        <p class="text-blue-100 uppercase tracking-widest text-xs font-bold mb-1">Établissement de</p>
                        <p class="text-lg font-medium leading-tight text-white">L'Université Abdelmalek Essaâdi</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full text-center py-8 text-gray-500 text-sm italic">
            &copy; {{ date('Y') }} ENSA Tanger • Département Génie Informatique
        </footer>

    </body>
</html>