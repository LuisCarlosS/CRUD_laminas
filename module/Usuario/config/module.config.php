<?php

namespace Usuario;

use Laminas\Router\Http\Segment;

return [

    'router' => [
        'routes' => [
            'usuario' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/usuario[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UsuarioController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'usuario' => __DIR__ . '/../view',
        ],
    ],
];