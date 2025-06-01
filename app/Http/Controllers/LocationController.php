<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Entity;
use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador para la gestión de ubicaciones geográficas.
 *
 * Este controlador gestiona las operaciones relacionadas con países, entidades
 * y municipios, incluyendo consultas jerárquicas y actualizaciones de estado.
 *
 * @package App\Http\Controllers
 */
class LocationController extends Controller
{
    /**
     * Muestra la vista principal de gestión de ubicaciones.
     *
     * @return \Illuminate\View\View Vista con los países ordenados por nombre
     */
    public function index()
    {
        $countries = Country::orderBy('Name')->get();
        return view('locations.manage', compact('countries'));
    }

    /**
     * Obtiene las entidades pertenecientes a un país específico.
     *
     * @param int $countryId Identificador del país
     * @return \Illuminate\Http\JsonResponse Lista de entidades en formato JSON
     */
    public function getEntities($countryId)
    {
        $entities = Entity::where('CountryId', $countryId)
            ->orderBy('Name')
            ->get();

        return response()->json($entities);
    }

    /**
     * Obtiene los municipios pertenecientes a una entidad específica.
     *
     * @param int $entityId Identificador de la entidad
     * @return \Illuminate\Http\JsonResponse Lista de municipios en formato JSON
     */
    public function getMunicipalities($entityId)
    {
        $municipalities = Municipality::where('EntityId', $entityId)
            ->orderBy('Name')
            ->get();

        return response()->json($municipalities);
    }

    /**
     * Obtiene los detalles completos de un municipio incluyendo su entidad y país.
     *
     * @param int $municipalityId Identificador del municipio
     * @return \Illuminate\Http\JsonResponse Detalles del municipio con sus relaciones
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el municipio no existe
     */
    public function getMunicipalityDetails($municipalityId)
    {
        $municipality = Municipality::with(['entity.country'])
            ->findOrFail($municipalityId);

        return response()->json($municipality);
    }

    /**
     * Actualiza el estado de activación de un municipio.
     *
     * @param \Illuminate\Http\Request $request Contiene el nuevo estado
     * @param int $municipalityId Identificador del municipio a actualizar
     * @return \Illuminate\Http\JsonResponse Resultado de la operación con los datos actualizados
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si el municipio no existe
     */
    public function updateMunicipalityStatus(Request $request, $municipalityId)
    {
        $municipality = Municipality::findOrFail($municipalityId);

        // Guardar el estado anterior
        $oldStatus = $municipality->Status;

        // Actualizar el estado
        $municipality->Status = $request->Status;
        $municipality->save();

        return response()->json([
            'success' => true,
            'oldStatus' => $oldStatus,
            'newStatus' => $municipality->Status,
            'municipality' => $municipality
        ]);
    }

    /**
     * Muestra la vista para consultas dinámicas de datos geográficos.
     *
     * @return \Illuminate\View\View Vista con los países ordenados por nombre
     */
    public function dynamicData()
    {
        $countries = Country::orderBy('Name')->get();
        return view('locations.dynamic-data', compact('countries'));
    }

    /**
     * Obtiene los detalles completos de una entidad específica.
     *
     * @param int $entityId Identificador de la entidad
     * @return \Illuminate\Http\JsonResponse Detalles de la entidad
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si la entidad no existe
     */
    public function getEntityDetails($entityId)
    {
        $entity = Entity::findOrFail($entityId);
        return response()->json($entity);
    }

    /**
     * Actualiza el nombre de una entidad dentro de una transacción para garantizar consistencia.
     *
     * @param \Illuminate\Http\Request $request Contiene el nuevo nombre
     * @param int $entityId Identificador de la entidad a actualizar
     * @return \Illuminate\Http\JsonResponse Resultado de la operación con los datos actualizados
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Si la entidad no existe
     */
    public function updateEntityName(Request $request, $entityId)
    {
        // Validación básica
        $request->validate([
            'Name' => 'required|string|max:256',
        ]);

        $entity = Entity::findOrFail($entityId);

        // Guardar el nombre anterior
        $oldName = $entity->Name;

        // Iniciar transacción para garantizar la consistencia
        DB::beginTransaction();

        try {
            // Actualizar el nombre
            $entity->Name = $request->Name;
            $entity->save();

            // Confirmar transacción
            DB::commit();

            return response()->json([
                'success' => true,
                'oldName' => $oldName,
                'newName' => $entity->Name,
                'entity' => $entity
            ]);
        } catch (\Exception $e) {
            // Revertir cambios en caso de error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el nombre: ' . $e->getMessage()
            ], 500);
        }
    }
}
