<x-guest-layout>
    <!-- Côté Gauche : Formulaire de réinitialisation -->
    <div class="flex-1 p-8 lg:p-12">
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Nouveau mot de passe</h2>
            <p class="text-gray-500">Sécurisez votre compte avec un mot de passe robuste.</p>
            <div class="h-1.5 w-16 bg-ensa-blue mt-2 rounded-full"></div>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="Email Académique" />
                <x-text-input id="email" class="block mt-1 w-full bg-gray-50" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-6">
                <x-input-label for="password" value="Nouveau mot de passe" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-6">
                <x-input-label for="password_confirmation" value="Confirmer le nouveau mot de passe" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-8">
                <x-primary-button class="w-full">
                    Réinitialiser le mot de passe
                </x-primary-button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-ensa-blue hover:underline font-medium">
                Retour à la connexion
            </a>
        </div>
    </div>

    <!-- Côté Droit : Visuel ENSA -->
    <div class="hidden lg:flex bg-ensa-blue w-2/5 flex-col items-center justify-center p-12 text-white relative overflow-hidden">
        <!-- Décorations -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-ensa-darkBlue rounded-full opacity-30"></div>
        <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-ensa-darkBlue rounded-full opacity-50"></div>
        
        <!-- Logo Textuel Blanc -->
        <div class="relative z-10 border-4 border-white p-6 rounded-2xl mb-6">
            <div class="text-white text-center">
                <span class="text-4xl font-black block leading-none tracking-tighter">ENSA</span>
                <div class="h-1 bg-white w-full my-1"></div>
                <span class="text-sm font-bold block tracking-[0.3em]">TANGER</span>
            </div>
        </div>

        <div class="relative z-10 text-center">
            <p class="text-blue-100 uppercase tracking-widest text-xs font-bold mb-2">Sécurité</p>
            <h3 class="text-xl font-bold">Protection du compte</h3>
            <p class="mt-2 text-blue-100 text-sm italic opacity-80">
                Université Abdelmalek Essaâdi
            </p>
        </div>
    </div>
</x-guest-layout>