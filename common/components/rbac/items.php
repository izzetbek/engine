<?php
return [
    'permAdminPanel' => [
        'type' => 2,
        'description' => 'Admin panel',
    ],
    'permCabinet' => [
        'type' => 2,
        'description' => 'Cabinet',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'children' => [
            'user',
            'permAdminPanel',
            'permCabinet',
        ],
    ],
    'participant' => [
        'type' => 1,
        'description' => 'Participant',
        'children' => [
            'user',
            'permCabinet',
        ],
    ],
];
