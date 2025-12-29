<x-guest-layout>
    <!-- Côté Gauche : Message de vérification -->
    <div class="flex-1 p-8 lg:p-12 flex flex-col justify-center">
        <div class="mb-8">
            <!-- Icône décorative -->
            <div class="inline-flex items-center justify-center w-16 h-16 bg-ensa-lightBlue text-ensa-blue rounded-2xl mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            
            <h2 class="text-3xl font-extrabold text-gray-900">Vérifiez votre email</h2>
            <p class="text-gray-500 mt-4 leading-relaxed">
                Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? 
            </p>
            <div class="h-1.5 w-16 bg-ensa-blue mt-4 rounded-full"></div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm font-medium rounded-r-xl">
                Un nouveau lien de vérification a été envoyé à l'adresse fournie lors de votre inscription.
            </div>
        @endif

        <div class="flex flex-col gap-4 mt-6">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center">
                    Renvoyer l'email de vérification
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-ensa-blue underline font-medium transition">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>

    <!-- Côté Droit : Visuel ENSA -->
    <div class="hidden lg:flex bg-ensa-blue lg:w-96 flex-col items-center justify-center p-12 text-white relative overflow-hidden">
        <!-- Décorations -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-ensa-darkBlue rounded-full opacity-30"></div>
        <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-ensa-darkBlue rounded-full opacity-50"></div>
        
        <!-- Logo ENSA Tanger -->
        <div class="relative z-10 bg-white p-6 rounded-3xl shadow-2xl mb-8 transform hover:scale-105 transition-transform duration-300">
            <div class="text-ensa-blue text-center">
                <span class="text-4xl font-black block leading-none">ENSA</span>
                <div class="h-1 bg-ensa-blue w-full my-1"></div>
                <span class="text-sm font-bold block tracking-[0.2em]">TANGER</span>
            </div>
        </div>

        <div class="relative z-10 text-center">
            <p class="text-blue-100 uppercase tracking-widest text-[10px] font-bold mb-1">Dernière étape</p>
            <p class="text-lg font-medium leading-tight text-white">Validation du compte</p>
            <p class="mt-4 text-sm text-blue-200 opacity-80 italic">Accès sécurisé UAE</p>
        </div>
    </div>
</x-guest-layout>