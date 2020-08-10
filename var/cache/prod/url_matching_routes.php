<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api.create' => [[['_route' => 'api.create', '_controller' => 'App\\Controller\\ApiController::apiCreate'], null, null, null, false, false, null]],
        '/api.status' => [[['_route' => 'api.status', '_controller' => 'App\\Controller\\ApiController::apiStatus'], null, null, null, false, false, null]],
        '/api.security' => [[['_route' => 'api.security', '_controller' => 'App\\Controller\\ApiController::apiSecurity'], null, null, null, false, false, null]],
        '/cliente-index' => [[['_route' => 'cliente-index', '_controller' => 'App\\Controller\\ClienteController::clienteIndex'], null, null, null, false, false, null]],
        '/home' => [[['_route' => 'home', '_controller' => 'App\\Controller\\HomeController::home'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/c(?'
                    .'|liente\\-(?'
                        .'|monto([^/]++)(*:36)'
                        .'|edit([^/]++)(*:55)'
                    .')'
                    .'|onfirm/([^/]++)/([^/]++)/([^/]++)(*:96)'
                .')'
                .'|/api\\.(?'
                    .'|get\\-user/([^/]++)/([^/]++)(*:140)'
                    .'|form([^/]++)/([^/]++)/([^/]++)(*:178)'
                .')'
                .'|/select([^/]++)(*:202)'
                .'|/registrar\\-cliente([^/]++)(*:237)'
                .'|/edit\\-save([^/]++)(*:264)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        36 => [[['_route' => 'cliente-monto', '_controller' => 'App\\Controller\\ApiController::clienteMonto'], ['tel'], null, null, false, true, null]],
        55 => [[['_route' => 'cliente-edit', '_controller' => 'App\\Controller\\ClienteController::clienteEdit'], ['tel'], null, null, false, true, null]],
        96 => [[['_route' => 'confirm', '_controller' => 'App\\Controller\\ApiController::confirm'], ['tel', 'monto', 'last4'], null, null, false, true, null]],
        140 => [[['_route' => 'api.get-user', '_controller' => 'App\\Controller\\ApiController::apiGetUser'], ['tel', 'monto'], null, null, false, true, null]],
        178 => [[['_route' => 'api.form', '_controller' => 'App\\Controller\\ApiController::apiForm'], ['tel', 'monto', 'last4'], null, null, false, true, null]],
        202 => [[['_route' => 'select', '_controller' => 'App\\Controller\\ApiController::select'], ['tel'], null, null, false, true, null]],
        237 => [[['_route' => 'registrar-cliente', '_controller' => 'App\\Controller\\ClienteController::registrarCliente'], ['tel'], null, null, false, true, null]],
        264 => [
            [['_route' => 'edit-save', '_controller' => 'App\\Controller\\ClienteController::editSave'], ['tel'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
