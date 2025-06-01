<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario para editar el perfil del usuario.
     */
    public function edit(Request $request)
    {
        $municipalities = Municipality::orderBy('Name')->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'municipalities' => $municipalities,
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
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->UserId, 'UserId')],
            'phoneNumber' => ['nullable', 'string', 'max:20'],
            'MunicipalityId' => ['nullable', 'exists:municipalities,MunId'],
        ]);

        if ($request->email !== $user->email) {
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina la cuenta del usuario.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
