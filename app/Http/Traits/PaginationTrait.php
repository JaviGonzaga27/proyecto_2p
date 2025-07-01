<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait PaginationTrait
{
    /**
     * Obtener y validar parámetros de paginación
     */
    protected function getPaginationParams(Request $request, string $modelType = 'default'): array
    {
        // Obtener configuración
        $perPageOptions = config('pagination.per_page_options', [10, 25, 50, 100]);
        $defaultPerPage = config('pagination.default_per_page', 10);
        $allowedSortFields = config("pagination.sort_fields.{$modelType}", ['id', 'created_at', 'updated_at']);

        // Campo por defecto específico para auditoría
        $defaultSortField = $modelType === 'auditoria' ? 'fecha_evento' : config('pagination.default_sort_field', 'created_at');
        $defaultSortDirection = config('pagination.default_sort_direction', 'desc');

        // Obtener parámetros de la request
        $perPage = $request->get('per_page', $defaultPerPage);
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', $defaultSortField);
        $sortDirection = $request->get('sort_direction', $defaultSortDirection);

        // Validar parámetros
        if (!is_numeric($perPage) || !in_array((int)$perPage, $perPageOptions)) {
            $perPage = $defaultPerPage;
        }

        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = $defaultSortField;
        }

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = $defaultSortDirection;
        }

        return [
            'per_page' => (int) $perPage,
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
            'per_page_options' => $perPageOptions,
        ];
    }

    /**
     * Preparar opciones para la tabla
     */
    protected function getTableOptions($paginatedData, array $params): array
    {
        return [
            'sort_by' => $params['sort_by'],
            'sort_direction' => $params['sort_direction'],
            'per_page_options' => $params['per_page_options'],
            'total_records' => $paginatedData->total(),
            'current_page' => $paginatedData->currentPage(),
            'last_page' => $paginatedData->lastPage(),
            'from' => $paginatedData->firstItem(),
            'to' => $paginatedData->lastItem(),
        ];
    }
}
