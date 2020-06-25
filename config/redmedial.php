<?php

return [
    'frontend_domain' => env('FRONTEND_DOMAIN'),
    'admin_domain' => env('ADMIN_DOMAIN'),

    'debugbar' => env('DEBUGBAR', true),

    'mobile-app' => [
        'android' => 'https://play.google.com/store/apps/details?id=com.raxkor.redmedial&amp;hl=ru',
        'apple' => 'https://apps.apple.com/us/app/redmedial/id1503517587?l=ru&amp;ls=1'
    ],

    'social' => [
        'facebook' => [
            'id' => 'PeriodicoElCiudadano',
            'link' => 'https://www.facebook.com/PeriodicoElCiudadano'
        ],
        'instagram' => [
            'id' => 'el.ciudadano',
            'link' => 'https://www.instagram.com/el.ciudadano'
        ],
        'twitter' => [
            'id' => 'el_ciudadano',
            'link' => 'https://twitter.com/@el_ciudadano'
        ],
        'youtube' => [
            'id' => 'ciudadanotv',
            'link' => 'https://www.youtube.com/channel/UCJrlV1drEWg2OEZFLUcFbTQ'
        ]
    ]
];
