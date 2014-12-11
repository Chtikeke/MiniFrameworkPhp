<?php
return [
    'views' => [
        'directory' => "./../views/",
    ],
    'routes' => [
        'register' => [
            'url'    => "/register",
            'method' => "GET",
            'action' => '\Iut\Controller\UserController::registerAction',
        ],
        'about' => [
            'url'    => "/about",
            'method' => "GET",
            'action' => '\Iut\Controller\DefaultController::aboutAction',
        ],
        'homepage' => [
            'url'    => "/",
            'method' => "GET",
            'action' => '\Iut\Controller\DefaultController::homepageAction',
        ],
        'profile' => [
            'url'    => "/profile",
            'method' => "GET",
            'action' => '\Iut\Controller\UserController::viewProfileAction',
        ],
    ]
];