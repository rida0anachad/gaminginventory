<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ── Afficher le formulaire login ──────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    // ── Traiter le formulaire login ───────────────────────────
    public function login(Request $request)
    {
        // Validation côté serveur 
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'L\'adresse e-mail est obligatoire.',
            'email.email'       => 'Format d\'e-mail invalide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        // Tentative de connexion
        if (Auth::attempt($request->only('email', 'password'), 
                          $request->boolean('remember'))) {
            $request->session()->regenerate(); // Sécurité : anti-fixation de session
            return redirect()->route('dashboard');
        }

        // Échec : retour avec message d'erreur
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Identifiants incorrects. Vérifiez votre e-mail et mot de passe.');
    }

    // ── Afficher le formulaire register ──────────────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    // ── Traiter le formulaire register ───────────────────────
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Le nom est obligatoire.',
            'email.unique'       => 'Cet e-mail est déjà utilisé.',
            'password.min'       => 'Minimum 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            return redirect()->route('dashboard')
                ->with('success', 'Compte créé avec succès !');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erreur lors de l\'inscription. Réessayez.');
        }
    }

    // ── Déconnexion ───────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Déconnecté avec succès.');
    }
}