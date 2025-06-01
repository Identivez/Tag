<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use App\Models\Country;
use App\Models\Municipality;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de direcciones.
 *
 * Este controlador maneja todas las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * relacionadas con las direcciones. Permite asociar direcciones a usuarios y vincularlas
 * con países y municipios para formar una estructura geográfica completa.
 *
 * @package App\Http\Controllers
 */
class AddressController extends Controller
{
    /**
     * Muestra un listado de todas las direcciones.
     *
     * Carga las direcciones con sus relaciones (usuario, país y municipio)
     * para evitar el problema N+1 en la vista.
     *
     * @return \Illuminate\View\View Vista con la lista de direcciones
     */
    public function index()
    {
        $addresses = Address::with(['user', 'country', 'municipality'])->get();
        return view('addresses.index', compact('addresses'));
    }

    /**
     * Muestra el formulario para crear una nueva dirección.
     *
     * Prepara los datos necesarios para los selectores del formulario:
     * - Lista de usuarios con nombres completos
     * - Lista de países
     * - Lista de municipios
     *
     * @return \Illuminate\View\View Vista con el formulario de creación
     */
    public function create()
    {
        // Combina firstName y lastName para el dropdown de usuarios
        $users = User::all()->mapWithKeys(function($u) {
            return [ $u->UserId => "{$u->firstName} {$u->lastName}" ];
        });

        // Obtener listas para los selectores
        $countries      = Country::pluck('Name', 'CountryId');
        $municipalities = Municipality::pluck('Name', 'MunId');

        return view('addresses.create', compact('users', 'countries', 'municipalities'));
    }

    /**
     * Almacena una nueva dirección en la base de datos.
     *
     * Valida los datos de entrada y crea un nuevo registro de dirección.
     * Luego redirecciona al listado con un mensaje de éxito.
     *
     * @param  \Illuminate\Http\Request  $request Datos del formulario
     * @return \Illuminate\Http\RedirectResponse Redirección al listado de direcciones
     */
    public function store(Request $request)
    {
        // Validación de todos los campos del formulario
        $data = $request->validate([
            'UserId'         => 'required|exists:users,UserId',              // ID de usuario válido
            'AddressLine1'   => 'required|string',                          // Línea principal obligatoria
            'AddressLine2'   => 'nullable|string',                          // Línea secundaria opcional
            'City'           => 'required|string',                          // Ciudad obligatoria
            'State'          => 'required|string',                          // Estado/Provincia obligatorio
            'ZipCode'        => 'nullable|integer',                         // Código postal opcional, numérico
            'Country'        => 'required|string',                          // Nombre del país obligatorio
            'CountryId'      => 'nullable|exists:countries,CountryId',      // Referencia al país opcional
            'MunicipalityId' => 'nullable|exists:municipalities,MunId',     // Referencia al municipio opcional
            'AddressType'    => 'required|string|max:50',                   // Tipo de dirección obligatorio
            'IsDefault'      => 'required|boolean',                         // Indicador de dirección predeterminada
            'IsActive'       => 'required|boolean',                         // Estado de activación
        ]);

        // Crear nuevo registro con los datos validados
        Address::create($data);

        // Redireccionar con mensaje de éxito
        return redirect()
            ->route('addresses.index')
            ->with('success', 'Dirección creada correctamente.');
    }

    /**
     * Muestra los detalles de una dirección específica.
     *
     * @param  \App\Models\Address  $address Dirección a mostrar (inyectada por route model binding)
     * @return \Illuminate\View\View Vista con los detalles de la dirección
     */
    public function show(Address $address)
    {
        return view('addresses.show', compact('address'));
    }

    /**
     * Muestra el formulario para editar una dirección existente.
     *
     * Prepara los datos necesarios para los selectores del formulario,
     * incluyendo la dirección a editar.
     *
     * @param  \App\Models\Address  $address Dirección a editar (inyectada por route model binding)
     * @return \Illuminate\View\View Vista con el formulario de edición
     */
    public function edit(Address $address)
    {
        // Prepara lista de usuarios con nombres completos para el selector
        $users = User::all()->mapWithKeys(function($u) {
            return [ $u->UserId => "{$u->firstName} {$u->lastName}" ];
        });

        // Obtener listas para los selectores
        $countries      = Country::pluck('Name', 'CountryId');
        $municipalities = Municipality::pluck('Name', 'MunId');

        return view('addresses.edit', compact('address', 'users', 'countries', 'municipalities'));
    }

    /**
     * Actualiza una dirección existente en la base de datos.
     *
     * Valida los datos de entrada y actualiza el registro.
     * No permite cambiar el usuario asociado a la dirección.
     *
     * @param  \Illuminate\Http\Request  $request Datos del formulario
     * @param  \App\Models\Address  $address Dirección a actualizar
     * @return \Illuminate\Http\RedirectResponse Redirección al listado de direcciones
     */
    public function update(Request $request, Address $address)
    {
        // Validación de campos (nota: no incluye UserId, no se permite cambiar el usuario)
        $data = $request->validate([
            'AddressLine1'   => 'required|string',
            'AddressLine2'   => 'nullable|string',
            'City'           => 'required|string',
            'State'          => 'required|string',
            'ZipCode'        => 'nullable|integer',
            'Country'        => 'required|string',
            'CountryId'      => 'nullable|exists:countries,CountryId',
            'MunicipalityId' => 'nullable|exists:municipalities,MunId',
            'AddressType'    => 'required|string|max:50',
            'IsDefault'      => 'required|boolean',
            'IsActive'       => 'required|boolean',
        ]);

        // Actualizar el registro con los datos validados
        $address->update($data);

        // Redireccionar con mensaje de éxito
        return redirect()
            ->route('addresses.index')
            ->with('success', 'Dirección actualizada correctamente.');
    }

    /**
     * Elimina una dirección de la base de datos.
     *
     * @param  \App\Models\Address  $address Dirección a eliminar
     * @return \Illuminate\Http\RedirectResponse Redirección al listado de direcciones
     */
    public function destroy(Address $address)
    {
        // Eliminar la dirección
        $address->delete();

        // Redireccionar con mensaje de éxito
        return redirect()
            ->route('addresses.index')
            ->with('success', 'Dirección eliminada correctamente.');
    }
}
