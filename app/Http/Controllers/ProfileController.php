<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\Entity;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario para editar el perfil del usuario.
     */
    public function edit(Request $request)
    {
        try {
            $municipalities = Municipality::orderBy('Name')->get();
            $entities = Entity::orderBy('Name')->get();
            $countries = Country::orderBy('Name')->get();
        } catch (\Exception $e) {
            $municipalities = collect();
            $entities = collect();
            $countries = collect();
        }

        return view('profile.edit', [
            'user' => $request->user(),
            'municipalities' => $municipalities,
            'entities' => $entities,
            'countries' => $countries,
        ]);
    }

    /**
     * Actualiza la información del perfil del usuario.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->UserId, 'UserId')],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'MunicipalityId' => ['nullable', 'exists:municipalities,MunId'],
            'EntityId' => ['nullable', 'exists:entities,EntityId'],
        ]);

        // Si el email cambió, marcar como no verificado
        if ($request->email !== $user->email) {
            $validated['email_verified_at'] = null;
        }

        try {
            $user->update($validated);
            return Redirect::route('profile.edit')->with('success', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Error al actualizar el perfil.');
        }
    }

    /**
     * Actualiza la contraseña del usuario.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        // Verificar contraseña actual
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        try {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            return Redirect::route('profile.edit')->with('success', 'Contraseña actualizada correctamente.');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Error al actualizar la contraseña.');
        }
    }

    /**
     * Elimina la cuenta del usuario.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required'],
        ]);

        $user = $request->user();

        // Verificar contraseña
        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['password' => 'La contraseña no es correcta.']);
        }

        try {
            // Logout del usuario
            Auth::logout();

            // Eliminar cuenta
            $user->delete();

            // Invalidar sesión
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::route('home')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Error al eliminar la cuenta.');
        }
    }

    /**
     * Muestra la vista del perfil (solo lectura).
     */
    public function show(Request $request)
    {
        $user = $request->user();

        try {
            $user->load(['municipality', 'entity']);
        } catch (\Exception $e) {
            // Si hay error cargando relaciones, continuar sin ellas
        }

        return view('profile.show', compact('user'));
    }
}
