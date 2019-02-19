<?php
return [
    'drivers' => [
        'defaultDriver' => [
            'class' => 'App\Components\Agent\Driver',
            'client' => \App\Components\Agent\Client::class,
            'formatter' => \App\Components\Agent\Formatter::class,
            'server' => 'https://tamir.ua/api/',
            'mirrors' => [
                'https://tamir.ua/app/',
                'https://tamir.ua/'
            ],
        ],
    ]
];