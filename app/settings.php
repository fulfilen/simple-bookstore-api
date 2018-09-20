<?php
return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'db' => [
            'driver'    =>  'mysql',
            'host'      =>  'localhost',
            'database'    => 'bookshop-api',
            'username'  =>  'root',
            'password'  =>  '',
            'collation' =>  'utf8_general_ci',
            'charset'   =>  'utf8',
            'prifix'    =>  '',
        ],

        //JWT KEY
        'jwt' => [
            'secret'    => '1a2b3c4d5e6f',
            'attribute' => 'decoded_token_data',
            'algorithm' => ["HS256"],
            'secure' => false,
        ],
    ],
];
