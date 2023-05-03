<?php

return [
    'jwt' => [
        'id' => 'UNIQUE-JWT-IDENTIFIER',  //a unique identifier for the JWT, typically a random string
        'expire' => 60,  //the short-lived JWT token is here set to expire after 5 min. (300)
    ],
];
