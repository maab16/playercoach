<?php

return [

    /*
    |-------------------------------------------------------------
    | Authentication
    |-------------------------------------------------------------
    |
    | Set auth config
    |
     */

    'auth'                 => [
        "token" => [
            "expiry" => 24 * 60 * 60 * 1000, // 24 hours as a milliseconds
        ],
        'user'  => [
            'model'        => 'App\\User',
            'table'        => 'users',
            'local_key'    => 'id',
        ],
    ],
];
