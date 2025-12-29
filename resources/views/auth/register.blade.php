<x-guest-layout>
    <div class="flex-1 p-8 lg:p-12 overflow-y-auto max-h-[700px]">
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Inscription</h2>
            <p class="text-gray-500">Créez votre compte étudiant</p>
            <div class="h-1 w-12 bg-ensa-blue mt-2 rounded-full"></div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="name" value="Nom" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                </div>
                <div>
                    <x-input-label for="prenom" value="Prénom" />
                    <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required />
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="email" value="Email Académique" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-input-label for="password" value="Mot de passe" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <div class="mt-8">
                <x-primary-button class="w-full">Créer mon compte</x-primary-button>
            </div>
                    <!-- Séparateur "OU" -->
    <div class="mt-6 flex items-center justify-center">
        <div class="border-t border-gray-300 w-full"></div>
        <span class="px-4 bg-white text-gray-500 text-sm">{{ __('OU') }}</span>
        <div class="border-t border-gray-300 w-full"></div>
    </div>

    <!-- Bouton Connexion avec Google -->
    <div class="mt-6">
        <button type="button" onclick="googleSignIn()" class="w-full flex items-center justify-center gap-3 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded transition">
            <svg class="w-5 h-5" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M47.532 24.5528C47.532 22.9218 47.3997 21.2811 47.1175 19.6761H24.48V28.9181H37.4434C36.9055 31.8988 35.177 34.5356 32.6461 36.2111V42.2078H40.3801C44.9217 38.0278 47.532 31.8548 47.532 24.5528Z" fill="#4285F4"/>
                <path d="M24.48 48.0016C30.9529 48.0016 36.4116 45.8764 40.3888 42.2078L32.6549 36.2111C30.5031 37.675 27.7252 38.5039 24.4888 38.5039C18.1598 38.5039 12.8575 34.2311 10.9612 28.5765H2.96576V34.7176C6.99898 42.7517 15.3939 48.0016 24.48 48.0016Z" fill="#34A853"/>
                <path d="M10.9612 28.5765C10.2827 26.1115 10.2827 23.5115 10.9612 20.9465V14.8054H2.96576C0.91083 19.0397 0.91083 23.7633 2.96576 28.5765L10.9612 28.5765Z" fill="#FBBC05"/>
                <path d="M24.48 9.49932C27.9016 9.44641 31.2086 10.7339 33.8866 13.2259L40.6395 6.47295C36.2637 2.43755 30.7375 0.000159263 24.48 0.000159263C15.3939 0.000159263 6.99898 6.03415 2.96576 14.8054L10.9612 20.9465C12.8575 15.2919 18.1598 11.0191 24.48 11.0191Z" fill="#EA4335"/>
            </svg>
            {{ __('Connexion avec Google') }}
        </button>
    </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Déjà inscrit ? <a href="{{ route('login') }}" class="text-ensa-blue font-bold hover:underline">Se connecter</a>
        </p>
    </div>

    <!-- Côté Droit : Bandeau -->
    <div class="hidden lg:flex bg-ensa-blue w-2/5 flex-col items-center justify-center p-12 text-white relative overflow-hidden">
        <div class="absolute -left-10 -top-10 w-48 h-48 bg-ensa-darkBlue rounded-full opacity-50"></div>
        <h3 class="text-2xl font-bold relative z-10 text-center">Bienvenue à l'ENSA Tanger</h3>
        <p class="mt-4 text-blue-100 text-center relative z-10">Rejoignez la plateforme numérique de l'établissement.</p>
    </div>



    <!-- Scripts Firebase (modulaire v9 compat) -->
<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-auth-compat.js"></script>

<script>
    const firebaseConfig = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        projectId: "{{ config('services.firebase.project_id') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
        appId: "{{ config('services.firebase.app_id') }}"
    };

    firebase.initializeApp(firebaseConfig);

    // Fonction globale
    window.googleSignIn = function() {
        const provider = new firebase.auth.GoogleAuthProvider();
        firebase.auth().signInWithPopup(provider)
            .then((result) => {
                return result.user.getIdToken();
            })
            .then((idToken) => {
                fetch("{{ route('google.login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ id_token: idToken })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect || "{{ route('dashboard') }}";
                    } else {
                        alert('Erreur connexion : ' + (data.message || 'Inconnue'));
                    }
                })
                .catch(err => console.error('Erreur fetch:', err));
            })
            .catch((error) => {
                console.error('Erreur Google Sign In:', error);
                alert('Erreur : ' + error.message);
            });
    };
</script>
</x-guest-layout>
