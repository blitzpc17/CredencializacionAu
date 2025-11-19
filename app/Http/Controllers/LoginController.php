<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('cms.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'usuario' => 'required|string', // Cambiar a 'usuario'
            'password' => 'required|string',
        ]);
        // Intentar autenticación usando el campo 'usuario'
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            // Verificar que el usuario esté activo
            if (!auth()->user()->activo) {
                Auth::logout();
                return back()->withErrors([
                    'usuario' => 'Tu cuenta está desactivada. Contacta al administrador.',
                ])->withInput($request->only('usuario'));
            }
            
            return $this->authenticated($request, Auth::user());
        }

        return back()->withErrors([
            'usuario' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->only('usuario'));
    }

    protected function authenticated(Request $request, $user)
    {
        // Tu lógica de redirección personalizada
        // Por ejemplo, basada en el perfil del usuario
     /*   if ($user->perfil && $user->perfil->nombre === 'Administrador') {
            return redirect('/admin');
        }*/
        
        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}

/*  validacion en php artisan tinker

// 1. Buscar un usuario específico
$user = App\Models\User::where('usuario', 'merino23')->first();

// 2. Verificar si existe
if ($user) {
    echo "Usuario encontrado:\n";
    echo "ID: " . $user->id . "\n";
    echo "Usuario: " . $user->usuario . "\n";
    echo "Activo: " . ($user->activo ? 'Sí' : 'No') . "\n";
    
    // 3. Verificar contraseña
    $passwordCheck = Hash::check('tu_password', $user->password);
    echo "Contraseña correcta: " . ($passwordCheck ? 'Sí' : 'No') . "\n";
    
    // 4. Intentar autenticación
    $credentials = ['usuario' => 'tu_usuario', 'password' => 'tu_password'];
    $attempt = Auth::attempt($credentials);
    echo "Auth::attempt: " . ($attempt ? 'True' : 'False') . "\n";
} else {
    echo "Usuario NO encontrado\n";
}*/


/*probar la encriptacon, remplazarla en bd par aver si es el hash */
/*

echo Hash::make('tu_password'); 

*/
