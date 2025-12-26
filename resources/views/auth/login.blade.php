<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Formulaire classique Email/Mot de passe -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

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

    <!-- Scripts Firebase (modulaire v9 compat) -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.0/firebase-app.js";
        import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/10.7.0/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);

        window.googleSignIn = async function() {
            const provider = new GoogleAuthProvider();
            try {
                const result = await signInWithPopup(auth, provider);
                const idToken = await result.user.getIdToken();

                const response = await fetch("{{ route('google.login') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ id_token: idToken })
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = data.redirect || "{{ route('dashboard') }}";
                } else {
                    alert("Erreur : " + data.message);
                }
            } catch (error) {
                console.error(error);
                alert("Erreur lors de la connexion Google");
            }
        };
    </script>
</x-guest-layout>