<?php

return [
    'roles' => [
        'super_user' => [
            'name'      => 'admin.roles.super_user',
            'sub_roles' => ['admin', 'customer'],
        ],
        'admin'      => [
            'name'      => 'admin.roles.admin',
            'sub_roles' => [],
        ],
        'customer'      => [
            'name'      => 'admin.roles.customer',
            'sub_roles' => [],
        ]
    ],
];
