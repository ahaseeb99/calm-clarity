<?php
header('Content-type: text/json');

$icon_url = SITEURL.'/storage/logo/';

$json = [
    'name' => get_option('pwa_app_name'),
    'short_name' => get_option('pwa_short_name'),
    'description' => get_option('pwa_app_description'),
    'background_color' => get_option('pwa_bg_color', '#ffffff'),
    'theme_color' => get_option('pwa_theme_color', '#ffffff'),
    'orientation' => 'any',
    'display' => 'standalone',
    'start_url' => '/',
    'scope' => '/',
    'icons' => [
        [
            'src' => $icon_url . get_option('pwa_icon'),
            'sizes' => '512X512'
        ],
        [
            'src' => $icon_url . get_option('pwa_icon'),
            'sizes' => '512X512',
            'purpose' => 'maskable'
        ],
        [
            'src' => $icon_url . 'icon-256-'.get_option('pwa_icon'),
            'sizes' => '256X256'
        ],
        [
            'src' => $icon_url . 'icon-128-'.get_option('pwa_icon'),
            'sizes' => '128X128'
        ]
    ]
];

echo json_encode($json, JSON_UNESCAPED_UNICODE);