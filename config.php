<?php
return [
    'db' => [
        'host'   => 'localhost',
        'user'   => 'root',
        'pass'   => '',
        'name'   => 'ferreteriaperalta',   // <- sin guion bajo
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
