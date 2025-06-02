
<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Entity;
use App\Models\Municipality;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Mostrar la vista principal de gestión de ubicaciones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $countries = Country::orderBy('Name')->get();
        return view('locations.manage', compact('countries'));
    }

    /**
     * Obtener entidades pertenecientes a un país específico.
     *
     * @param int $countryId ID del país
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEntities($countryId)
    {
        $entities = Entity::where('CountryId', $countryId)
            ->orderBy('Name')
            ->get();

        return response()->json($entities);
    }

    /**
     * Obtener municipios pertenecientes a una entidad específica.
     *
     * @param int $entityId ID de la entidad
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMunicipalities($entityId)
    {
        $municipalities = Municipality::where('EntityId', $entityId)
            ->orderBy('Name')
            ->get();

        return response()->json($municipalities);
    }

    /**
     * Obtener detalles completos de un municipio, incluyendo su entidad y país.
     *
     * @param int $municipalityId ID del municipio
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMunicipalityDetails($municipalityId)
    {
        $municipality = Municipality::with(['entity.country'])
            ->findOrFail($municipalityId);

        return response()->json($municipality);
    }

    /**
     * Actualizar el estado de activación de un municipio.
     *
     * @param \Illuminate\Http\Request $request Contiene el nuevo estado
     * @param int $municipalityId ID del municipio
     * @return \Illuminate\Http\JsonResponse
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
}
