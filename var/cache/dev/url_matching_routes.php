<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/api.create' => [[['_route' => 'api.create', '_controller' => 'App\\Controller\\ApiController::apiCreate'], null, null, null, false, false, null]],
        '/api.status' => [[['_route' => 'api.status', '_controller' => 'App\\Controller\\ApiController::apiStatus'], null, null, null, false, false, null]],
        '/api.security' => [[['_route' => 'api.security', '_controller' => 'App\\Controller\\ApiController::apiSecurity'], null, null, null, false, false, null]],
        '/cliente-index' => [[['_route' => 'cliente-index', '_controller' => 'App\\Controller\\ClienteController::clienteIndex'], null, null, null, false, false, null]],
        '/home' => [[['_route' => 'home', '_controller' => 'App\\Controller\\HomeController::home'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/c(?'
                    .'|liente\\-(?'
                        .'|monto([^/]++)(*:198)'
                        .'|edit([^/]++)(*:218)'
                    .')'
                    .'|onfirm/([^/]++)/([^/]++)(*:251)'
                .')'
                .'|/api\\.(?'
                    .'|get\\-user/([^/]++)/([^/]++)(*:296)'
                    .'|form([^/]++)/([^/]++)(*:325)'
                .')'
                .'|/select([^/]++)(*:349)'
                .'|/registrar\\-cliente([^/]++)(*:384)'
                .'|/edit\\-save([^/]++)(*:411)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        198 => [[['_route' => 'cliente-monto', '_controller' => 'App\\Controller\\ApiController::clienteMonto'], ['tel'], null, null, false, true, null]],
        218 => [[['_route' => 'cliente-edit', '_controller' => 'App\\Controller\\ClienteController::clienteEdit'], ['tel'], null, null, false, true, null]],
        251 => [[['_route' => 'confirm', '_controller' => 'App\\Controller\\ApiController::confirm'], ['tel', 'monto'], null, null, false, true, null]],
        296 => [[['_route' => 'api.get-user', '_controller' => 'App\\Controller\\ApiController::apiGetUser'], ['tel', 'monto'], null, null, false, true, null]],
        325 => [[['_route' => 'api.form', '_controller' => 'App\\Controller\\ApiController::apiForm'], ['tel', 'monto'], null, null, false, true, null]],
        349 => [[['_route' => 'select', '_controller' => 'App\\Controller\\ApiController::select'], ['tel'], null, null, false, true, null]],
        384 => [[['_route' => 'registrar-cliente', '_controller' => 'App\\Controller\\ClienteController::registrarCliente'], ['tel'], null, null, false, true, null]],
        411 => [
            [['_route' => 'edit-save', '_controller' => 'App\\Controller\\ClienteController::editSave'], ['tel'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
