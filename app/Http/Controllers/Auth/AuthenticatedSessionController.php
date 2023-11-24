<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Admin;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{

    protected $guard = 'admin';


    protected function guard()
{
    return Auth::guard('admin');
}
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login'); 
    }

    public function adminLogin() {
        return view ('fronts.adminLogin');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentifier la requête avec les fonctionnalités fournies par Laravel
        $request->authenticate();
    
        // Régénérer la session
        $request->session()->regenerate();
    
        // Rechercher un admin avec l'email fourni
        $admin = Admin::where('email', $request->input('email'))->first();
    
        // Rechercher un utilisateur avec l'email fourni
        $user = User::where('email', $request->input('email'))->first();
    
        if ($admin) {
            // Vérifier si le mot de passe correspond
            if (Hash::check($request->input('password'), $admin->password)) {
                // Stocker les informations de l'admin en session
                $request->session()->put('admin', $admin);
                // Rediriger vers le tableau de bord admin
                return redirect()->route('adminDashboard');
            } else {
                // Retourner un message d'erreur si le mot de passe est incorrect
                return redirect()->back()->with('sessions', 'Identifiants incorrects');
            }
        } elseif ($user) {
            // Vérifier si le mot de passe correspond
            if (Hash::check($request->input('password'), $user->password)) {
                // Stocker les informations de l'utilisateur en session
                $request->session()->put('user', $user);
                // Rediriger en fonction du rôle de l'utilisateur
                switch ($user->role) {
                    case 'client':
                        return redirect()->route('clientDashboard');
                    case 'etudiant':
                        return redirect()->route('etudiantDashboard');
                    case 'redacteur':
                        return redirect()->route('redacteurDashboard');
                    default:
                        // Rediriger vers une route par défaut si le rôle n'est pas reconnu
                        return redirect()->route('defaultDashboard');
                }
            } else {
                // Retourner un message d'erreur si le mot de passe est incorrect
                return redirect()->back()->with('sessions', 'Identifiants incorrects');
            }
        } else {
            // Si ni admin ni utilisateur n'est trouvé avec cet email
            return redirect()->back()->with('sessions', 'Identifiants incorrects');
        }
    }
    
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
