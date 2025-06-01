<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Municipality;
use Illuminate\Http\Request;

/**
 * Controlador para manejar solicitudes AJAX.
 *
 * Este controlador especializado gestiona las solicitudes asíncronas (AJAX)
 * relacionadas con la carga dinámica de datos para selectores dependientes
 * en la interfaz de usuario, específicamente para la jerarquía geográfica
 * país > entidad > municipio.
 *
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{
    /**
     * Carga entidades pertenecientes a un país para un selector dinámico.
     *
     * Este método recibe el ID de un país y devuelve en formato JSON
     * todas las entidades asociadas a ese país, ordenadas alfabéticamente.
     * Se utiliza para actualizar dinámicamente un selector de entidades
     * cuando el usuario selecciona un país en la interfaz.
     *
     * @param int $id_pais Identificador del país seleccionado
     * @return \Illuminate\Http\JsonResponse Lista de entidades en formato JSON
     */
    public function cambia_combo($id_pais)
    {
        // Consulta optimizada: solo selecciona los campos necesarios
        $entidades = Entity::where('CountryId', $id_pais)
            ->select('EntityId', 'Name')  // Solo incluye ID y nombre para reducir payload
            ->orderBy('Name')             // Ordena alfabéticamente por nombre
            ->get();                      // Ejecuta la consulta

        // Devuelve los resultados en formato JSON para ser procesados por JavaScript
        return response()->json($entidades);
    }

    /**
     * Carga municipios pertenecientes a una entidad para un selector dinámico.
     *
     * Este método recibe el ID de una entidad y devuelve en formato JSON
     * todos los municipios asociados a esa entidad, ordenados alfabéticamente.
     * Se utiliza para actualizar dinámicamente un selector de municipios
     * cuando el usuario selecciona una entidad en la interfaz.
     *
     * @param int $id_entidad Identificador de la entidad seleccionada
     * @return \Illuminate\Http\JsonResponse Lista de municipios en formato JSON
     */
    public function cambia_combo_2($id_entidad)
    {
        // Consulta optimizada: solo selecciona los campos necesarios
        $municipios = Municipality::where('EntityId', $id_entidad)
            ->select('MunId', 'Name')    // Solo incluye ID y nombre para reducir payload
            ->orderBy('Name')            // Ordena alfabéticamente por nombre
            ->get();                     // Ejecuta la consulta

        // Devuelve los resultados en formato JSON para ser procesados por JavaScript
        return response()->json($municipios);
    }
}
