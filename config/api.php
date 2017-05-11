<?php

return [
    'twitter' => [
        'oauth_access_token'        => env('TWITTER_OAUTH_ACCESS_TOKEN', null),
        'oauth_access_token_secret' => env('TWITTER_OAUTH_ACCESS_TOKEN_SECRET', null),
        'consumer_key'              => env('TWITTER_CONSUMER_KEY', null),
        'consumer_secret'           => env('TWITTER_CONSUMER_SECRET', null),
    ],
];
