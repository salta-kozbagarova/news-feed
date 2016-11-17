<?php
return [
    'users.management' => [
        'type' => 2,
        'description' => 'Manage users',
    ],
    'posts.management' => [
        'type' => 2,
        'description' => 'Manage posts',
    ],
    'notification.management' => [
        'type' => 2,
        'description' => 'Manage a notification',
    ],
    'user' => [
        'type' => 1,
    ],
    'author' => [
        'type' => 1,
        'children' => [
            'posts.management',
        ],
    ],
    'administrator' => [
        'type' => 1,
        'children' => [
            'users.management',
            'author',
            'notification.management',
        ],
    ],
];
