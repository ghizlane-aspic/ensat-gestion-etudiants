<x-guest-layout>
    <!-- Côté Gauche : Formulaire -->
    <div class="flex-1 p-8 lg:p-12">
        <div class="mb-8">
            <h2 class="text-3 font-extrabold text-gray-900">Connexion</h2>
            <p class="text-gray-500">Heureux de vous revoir !</p>
            <div class="h-1 w-12 bg-ensa-blue mt-2 rounded-full"></div>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-input-label for="email" value="Email Académique" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" value="Mot de passe" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-ensa-blue focus:ring-ensa-blue" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-ensa-blue hover:underline" href="{{ route('password.request') }}">Oublié ?</a>
                @endif
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full">Se Connecter</x-primary-button>
            </div>
        </form>

        <div class="mt-6 flex items-center justify-center gap-4">
            <div class="h-px bg-gray-200 flex-grow"></div>
            <span class="text-gray-400 text-sm">OU</span>
            <div class="h-px bg-gray-200 flex-grow"></div>
        </div>

        <button onclick="googleSignIn()" class="mt-6 w-full flex items-center justify-center gap-3 bg-white border border-gray-300 py-3 rounded-xl hover:bg-gray-50 transition font-semibold text-gray-700">
            <svg class="w-5 h-5" viewBox="0 0 48 48"><path d="M47.532 24.5528C47.532 22.9218 47.3997 21.2811 47.1175 19.6761H24.48V28.9181H37.4434C36.9055 31.8988 35.177 34.5356 32.6461 36.2111V42.2078H40.3801C44.9217 38.0278 47.532 31.8548 47.532 24.5528Z" fill="#4285F4"/><path d="M24.48 48.0016C30.9529 48.0016 36.4116 45.8764 40.3888 42.2078L32.6549 36.2111C30.5031 37.675 27.7252 38.5039 24.4888 38.5039C18.1598 38.5039 12.8575 34.2311 10.9612 28.5765H2.96576V34.7176C6.99898 42.7517 15.3939 48.0016 24.48 48.0016Z" fill="#34A853"/><path d="M10.9612 28.5765C10.2827 26.1115 10.2827 23.5115 10.9612 20.9465V14.8054H2.96576C0.91083 19.0397 0.91083 23.7633 2.96576 28.5765L10.9612 28.5765Z" fill="#FBBC05"/><path d="M24.48 9.49932C27.9016 9.44641 31.2086 10.7339 33.8866 13.2259L40.6395 6.47295C36.2637 2.43755 30.7375 0.000159263 24.48 0.000159263C15.3939 0.000159263 6.99898 6.03415 2.96576 14.8054L10.9612 20.9465C12.8575 15.2919 18.1598 11.0191 24.48 11.0191Z" fill="#EA4335"/></svg>
            Google
        </button>

        <p class="mt-8 text-center text-sm text-gray-600">
            Pas encore de compte ? <a href="{{ route('register') }}" class="text-ensa-blue font-bold hover:underline">S'inscrire</a>
        </p>
    </div>

    <!-- Côté Droit : Visuel ENSA -->
    <div class="hidden lg:flex bg-ensa-blue w-2/5 flex-col items-center justify-center p-12 text-white relative overflow-hidden">
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-ensa-darkBlue rounded-full opacity-50"></div>
        <div class="relative z-10 bg-white p-6 rounded-2xl shadow-xl mb-6 transform rotate-3">
            <div class="text-ensa-blue text-center">
                <span class="text-3xl font-black block leading-none">ENSA</span>
                <div class="h-0.5 bg-ensa-blue w-full my-1"></div>
                <span class="text-xs font-bold block tracking-widest">TANGER</span>
            </div>
        </div>
        <div class="relative z-10 text-center">
            <h3 class="text-xl font-bold mb-2">Portail Académique</h3>
            <p class="text-blue-100 text-sm">Accédez à vos notes, emplois du temps et ressources pédagogiques.</p>
        </div>
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