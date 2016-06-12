<?php
return array(
    'controllers' => [
        'invokables' =>[
            'Appointment\Controller\Appointment' => 'Appointment\Controller\AppointmentController'
        ],
    ],
    'routes' => [
        'routes' => [
            'appointment' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/appointment[/][:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*'
                    ],
                    'defaults' =>[
                        'controller' => 'Appointment\Controller\appointment'
                    ]
                ]
            ]
        ]
    ]
);