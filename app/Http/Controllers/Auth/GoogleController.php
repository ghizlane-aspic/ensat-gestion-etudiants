<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function login(Request $request)
    {
        // Accept both id_token and token keys for compatibility
        $rawToken = $request->input('id_token') ?: $request->input('token');
        Log::info('Google token received', [
            'has_id_token' => (bool) $request->input('id_token'),
            'has_token' => (bool) $request->input('token')
        ]);

        if (!$rawToken || !is_string($rawToken)) {
            return response()->json([
                'success' => false,
                'message' => 'Missing Google ID token.',
            ], 422);
        }

        try {
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($rawToken);
            $googleUid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name') ?? 'Utilisateur';
            $prenom = $verifiedIdToken->claims()->get('given_name') ?? '';
            $photoUrl = $verifiedIdToken->claims()->get('picture') ?? null;

            // Chercher ou créer l'utilisateur
            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => explode(' ', $name)[1] ?? $name, // Nom de famille (approximation)
                    'prenom' => $prenom,
                    'email' => $email,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'etudiant', // Par défaut étudiant
                    'photo' => $photoUrl, // Optionnel : stocker l'URL photo Google
                    'email_verified_at' => now(),
                ]);
            } else {
                // Si l'utilisateur existe déjà, on peut mettre à jour prénom/photo si besoin
                $user->update([
                    'prenom' => $prenom ?: $user->prenom,
                    'photo' => $photoUrl ?: $user->photo,
                ]);
            }

            // Connexion classique Laravel (session web)
            Auth::login($user);

            // Regenerate session to ensure authentication state is properly stored
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'redirect' => route('dashboard'),
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            Log::warning('Google login failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Token Google invalide ou expiré.',
            ], 401);
        }
    }
}