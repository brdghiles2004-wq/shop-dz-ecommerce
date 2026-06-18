<?php
return [
    'cloud_url' => env('CLOUDINARY_URL', 'cloudinary://878249653231955:pzRCoVSmw3D24EqomupdO8RLa6Y@dh4kx33by'),
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'dh4kx33by'),
        'api_key'    => env('CLOUDINARY_API_KEY', '878249653231955'),
        'api_secret' => env('CLOUDINARY_API_SECRET', 'pzRCoVSmw3D24EqomupdO8RLa6Y'),
        'secure'     => true,
    ],
    'upload_preset' => null,
    'fetch_image'   => false,
    'transformation' => [],
    'notification_url' => null,
];