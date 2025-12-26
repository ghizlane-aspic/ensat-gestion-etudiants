<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;

class GoogleController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        $auth = Firebase::auth();

        try {
            $verifiedIdToken = $auth->verifyIdToken($request->id_token);
            $googleUser = $verifiedIdToken->claims();

            $email = $googleUser->get('email');
            $googleId = $googleUser->get('sub'); // UID Google
            $name = $googleUser->get('name') ?? explode('@', $email)[0];

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'prenom' => $googleUser->get('given_name') ?? '',
                    'email' => $email,
                    'password' => Hash::make(Str::random(16)), // Mot de passe aléatoire
                    'role' => 'etudiant', // Par défaut étudiant, ou logique custom
                    'email_verified_at' => now(),
                    // 'google_id' => $googleId, // Si vous ajoutez le champ
                ]);
            }

            // Login avec Sanctum
            $token = $user->createToken('google-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
                'redirect' => route('dashboard'), // Ou /profil pour étudiant
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Token invalide'], 401);
        }
    }
}