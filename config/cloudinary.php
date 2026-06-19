<?php
return [
    'cloud_url' => env('CLOUDINARY_URL', 'cloudinary://186449125321973:2tFFu2BVNhEleZgAlN6zJZQFyDM@dh4kx33by'),
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME', 'dh4kx33by'),
        'api_key'    => env('CLOUDINARY_API_KEY', '186449125321973'),
        'api_secret' => env('CLOUDINARY_API_SECRET', '2tFFu2BVNhEleZgAlN6zJZQFyDM'),
        'secure'     => true,
    ],
    'upload_preset' => null,
    'fetch_image'   => false,
    'transformation' => [],
    'notification_url' => null,
];