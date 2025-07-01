<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración de Paginación
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar las opciones de paginación para tu aplicación.
    |
    */

    'per_page_options' => [10, 25, 50, 100],
    'default_per_page' => 10,
    'max_per_page' => 100,

    /*
    |--------------------------------------------------------------------------
    | Campos de Ordenamiento Permitidos
    |--------------------------------------------------------------------------
    |
    | Define los campos por los que se puede ordenar en diferentes modelos
    |
    */
    'sort_fields' => [
        'users' => ['id', 'name', 'email', 'created_at', 'updated_at', 'email_verified_at'],
        'productos' => ['id', 'nombre', 'codigo', 'cantidad', 'precio', 'created_at', 'updated_at'],
        'auditoria' => ['id', 'accion', 'fecha_evento', 'producto_id', 'user_id', 'created_at'],
        'productos_eliminados' => ['id', 'nombre', 'codigo', 'cantidad', 'precio', 'deleted_at', 'updated_at'],
    ],

    'default_sort_field' => 'created_at',
    'default_sort_direction' => 'desc',
];
