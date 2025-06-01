<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Municipality;
use App\Models\Entity;
use App\Models\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los usuarios con su municipio relacionado
        $users = User::with('municipality')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todas las municipalidades, entidades y países
        $municipalities = Municipality::orderBy('Name')->get();
        $entities = Entity::orderBy('Name')->get();
        $paises = Country::orderBy('Name')->get();  // Obtener todos los países

        // Pasar las variables a la vista
        return view('users.create', compact('municipalities', 'entities', 'paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos entrantes
        $data = $request->validate([
            'firstName'      => 'nullable|string|max:255',
            'lastName'       => 'nullable|string|max:255',
            'createdAt'      => 'nullable|date_format:Y-m-d\TH:i',
            'email'          => 'required|email|max:256|unique:users,email',
            'password'       => 'required|string|min:8',
            'phoneNumber'    => 'nullable|string|max:50',
            'MunicipalityId' => 'nullable|exists:municipalities,MunId',
            'EntityId'       => 'required|exists:entities,EntityId'  // Aseguramos que la entidad esté presente
        ]);

        // Generar el UserId automáticamente (si es necesario)
        $data['UserId'] = uniqid();  // Ejemplo de generación de ID único

        // Convertir createdAt a formato MySQL DATETIME si se recibe
        if (!empty($data['createdAt'])) {
            $data['createdAt'] = Carbon::createFromFormat(
                'Y-m-d\TH:i',
                $data['createdAt']
            )->format('Y-m-d H:i:s');
        }

        // Crear el usuario
        User::create($data);

        // Redirigir al índice de usuarios con mensaje de éxito
        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('municipality');  // Cargar municipio
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Obtener las municipalidades, entidades y países
        $municipalities = Municipality::orderBy('Name')->get();
        $entities = Entity::orderBy('Name')->get();
        $paises = Country::orderBy('Name')->get();

        // Pasar los datos a la vista de edición
        return view('users.edit', compact('user', 'municipalities', 'entities', 'paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validación para la actualización de datos
        $rules = [
            'firstName'      => 'nullable|string|max:255',
            'lastName'       => 'nullable|string|max:255',
            'createdAt'      => 'nullable|date_format:Y-m-d\TH:i',
            'email'          => 'required|email|max:256|unique:users,email,' . $user->UserId . ',UserId',
            'password'       => 'nullable|string|min:8',
            'phoneNumber'    => 'nullable|string|max:50',
            'MunicipalityId' => 'nullable|exists:municipalities,MunId',
            'EntityId'       => 'required|exists:entities,EntityId'  // Aseguramos que la entidad esté presente
        ];

        $data = $request->validate($rules);

        // Convertir createdAt a formato MySQL DATETIME si se recibe
        if (!empty($data['createdAt'])) {
            $data['createdAt'] = Carbon::createFromFormat(
                'Y-m-d\TH:i',
                $data['createdAt']
            )->format('Y-m-d H:i:s');
        }

        // Solo actualizar la contraseña si se recibe
        if (empty($data['password'])) {
            unset($data['password']);
        }

        // Actualizar el usuario
        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Eliminar el usuario
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Get entities based on the selected country.
     */
    public function getEntitiesByCountry($id_pais)
    {
        // Obtener las entidades relacionadas con el país seleccionado
        $entities = Entity::where('CountryId', $id_pais)
            ->select('EntityId', 'Name')
            ->orderBy('Name')
            ->get();

        return response()->json($entities);  // Devolver las entidades como JSON
    }

    /**
     * Get municipalities based on the selected entity.
     */
    public function getMunicipalitiesByEntity($id_entidad)
    {
        // Obtener los municipios relacionados con la entidad seleccionada
        $municipalities = Municipality::where('EntityId', $id_entidad)
            ->select('MunId', 'Name')
            ->orderBy('Name')
            ->get();

        return response()->json($municipalities);  // Devolver los municipios como JSON
    }
}
