<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'bikes_photo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/bikes_photo'),
            'url' => env('APP_URL').'/storage/bikes_photo/',
        ],

        'spare_parts_photo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/spare_parts_photo'),
            'url' => env('APP_URL').'/storage/spare_parts_photo/',
        ],
        'newstutorial_photo' => [
            'driver' => 'local',
            'root' => storage_path('app/public/newstutorial_photo'),
            'url' => env('APP_URL').'/storage/newstutorial_photo/',
        ],
        'newstutorial_video' => [
            'driver' => 'local',
            'root' => storage_path('app/public/newstutorial_video'),
            'url' => env('APP_URL').'/storage/newstutorial_video/',
        ],
        'users_avatar' => [
            'driver' => 'local',
            'root' => storage_path('app/public/users_avatar'),
            'url' => env('APP_URL').'/storage/users_avatar/',
        ],
        'media' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url'    => env('APP_URL').'/media',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
