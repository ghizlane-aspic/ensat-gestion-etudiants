<x-guest-layout>
    <!-- Côté Gauche : Formulaire de récupération -->
    <div class="flex-1 p-8 lg:p-12 flex flex-col justify-center">
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Mot de passe oublié ?</h2>
            <p class="text-gray-500 mt-2">
                Pas de souci. Indiquez votre adresse email académique et nous vous enverrons un lien pour en choisir un nouveau.
            </p>
            <div class="h-1.5 w-16 bg-ensa-blue mt-4 rounded-full"></div>
        </div>

        <!-- Statut de la session (Message de succès après envoi) -->
        <x-auth-session-status class="mb-6 bg-green-50 p-4 rounded-xl text-green-700 border border-green-100" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Email Académique" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="nom.prenom@uae.ac.ma" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-8">
                <x-primary-button class="w-full">
                    Envoyer le lien de réinitialisation
                </x-primary-button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="text-sm text-ensa-blue hover:text-ensa-darkBlue font-bold flex items-center justify-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour à la connexion
            </a>
        </div>
    </div>

    <!-- Côté Droit : Visuel ENSA -->
    <div class="hidden lg:flex bg-ensa-blue lg:w-96 flex-col items-center justify-center p-12 text-white relative overflow-hidden">
        <!-- Décorations -->
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-ensa-darkBlue rounded-full opacity-50"></div>
        <div class="absolute -left-10 -top-10 w-32 h-32 bg-ensa-darkBlue rounded-full opacity-30"></div>
        
        <!-- Logo ENSA Tanger -->
        <div class="relative z-10 bg-white p-6 rounded-3xl shadow-2xl mb-8 transform -rotate-3">
            <div class="text-ensa-blue text-center">
                <span class="text-4xl font-black block leading-none">ENSA</span>
                <div class="h-1 bg-ensa-blue w-full my-1"></div>
                <span class="text-sm font-bold block tracking-[0.2em]">TANGER</span>
            </div>
        </div>

        <div class="relative z-10 text-center">
            <p class="text-blue-100 uppercase tracking-widest text-xs font-bold mb-1 italic">Sécurité & Accès</p>
            <p class="text-lg font-medium leading-tight">Service de Récupération de Compte</p>
        </div>
    </div>
</x-guest-layout>