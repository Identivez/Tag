<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Municipality;
use Illuminate\Http\Request;

/**
 * Controlador para manejar solicitudes AJAX.
 *
 * Este controlador especializado gestiona solicitudes asíncronas relacionadas
 * con la jerarquía geográfica País > Entidad > Municipio y algunas funciones
 * auxiliares para consultas dinámicas.
 *
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{
    /**
     * Carga entidades asociadas a un país para selectores dependientes.
     *
     * @param int $id_pais
     * @return \Illuminate\Http\JsonResponse
     */
    public function cambia_combo($id_pais)
    {
        $entidades = Entity::where('CountryId', $id_pais)
            ->select('EntityId', 'Name')
            ->orderBy('Name')
            ->get();

        return response()->json($entidades, 200);
    }

    /**
     * Carga municipios asociados a una entidad para selectores dependientes.
     *
     * @param int $id_entidad
     * @return \Illuminate\Http\JsonResponse
     */
    public function cambia_combo_2($id_entidad)
    {
        $municipios = Municipality::where('EntityId', $id_entidad)
            ->select('MunId', 'Name')
            ->orderBy('Name')
            ->get();

        return response()->json($municipios, 200);
    }

    /**
     * Buscar municipios por texto (útil para autocompletar).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarMunicipios(Request $request)
    {
        $term = $request->input('q', '');

        $municipios = Municipality::where('Name', 'like', '%' . $term . '%')
            ->limit(10)
            ->get(['MunId', 'Name']);

        return response()->json($municipios, 200);
    }

    /**
     * Obtener detalles de una entidad específica (para mostrar info adicional).
     *
     * @param int $id_entidad
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEntidadDetalles($id_entidad)
    {
        $entidad = Entity::with('country')->find($id_entidad);

        if (!$entidad) {
            return response()->json(['error' => 'Entidad no encontrada'], 404);
        }

        return response()->json($entidad, 200);
    }

    /**
     * Obtener detalles de un municipio específico.
     *
     * @param int $id_municipio
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMunicipioDetalles($id_municipio)
    {
        $municipio = Municipality::with('entity')->find($id_municipio);

        if (!$municipio) {
            return response()->json(['error' => 'Municipio no encontrado'], 404);
        }

        return response()->json($municipio, 200);
    }
}
