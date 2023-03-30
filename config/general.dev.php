<?php

use Monolog\Level;
use SailCMS\Assets\Transformer;
use SailCMS\Logging\Database;
use SailCMS\Session\Stateless;

return [
    [
        'devMode' => true,
        'allowAdmin' => true,
        'adminTrigger' => 'admin',
        'cache' => [
            'use' => (bool)env('cache_use', 'false'),
            'host' => env('cache_host', 'localhost'),
            'user' => env('cache_user', ''),
            'password' => env('cache_password', ''),
            'port' => 6379,
            'database' => 10,
            'ssl' => [
                'verify' => true,
                'cafile' => '/path/to/file'
            ]
        ],
        'emails' => [
            'from' => 'no-reply@sailcms.io',
            'sendNewAccount' => true,
            'globalContext' => [
                // You can add your own static context variables
                'locales' => [
                    'fr' => [
                        'follow' => 'Suivez-nous',
                        'privacy' => 'Politique de confidentialité',
                        'contact' => 'Contactez nous',
                        'faq' => 'FAQ',
                        'team' => "L'équipe Cubeler",
                        'thanks' => 'Merci'
                    ],
                    'en' => [
                        'follow' => 'Follow Us',
                        'privacy' => 'Privacy Policy',
                        'contact' => 'Contact Us',
                        'faq' => 'FAQ',
                        'team' => 'The Cubeler Team',
                        'thanks' => 'Thank'
                    ]
                ]
            ]
        ],
        'passwords' => [
            'minLength' => 8,
            'maxLength' => 64,
            'enforceAlphanum' => true,
            'enforceUpperLower' => true
        ],
        'CSRF' => [
            'use' => true,
            'leeway' => 5,
            'expiration' => 120
        ],
        'graphql' => [
            'active' => true,
            'trigger' => 'graphql',
            'depthLimit' => 5
        ],
        'cors' => [
            'use' => true,
            'origins' => ['*'],
            'allowCredentials' => true,
            'maxAge' => 86400,
            'methods' => ['POST', 'GET', 'DELETE', 'PUT', 'OPTIONS'],
            'headers' => ['Accept', 'Upgrade-Insecure-Requests', 'Content-Type', 'x-requested-with', 'x-access-token']
        ],
        'session' => [
            'mode' => Stateless::class,
            'httpOnly' => true,
            'samesite' => 'strict',
            'ttl' => 21_600, // 6h
            'jwt' => [
                'issuer' => 'SailCMS',
                'domain' => 'sailcms.site'
            ]
        ],
        'templating' => [
            'cache' => false,
            'vueCompat' => false
        ],
        'tfa' => [
            'issuer' => 'SailCMS',
            'whitelist' => 'localhost,leeroy.ca',
            'length' => 6,
            'expire' => 30,
            'format' => 'svg',
            'main_color' => '',
            'hover_color' => ''
        ],
        'logging' => [
            'useRay' => true,
            'loggerName' => 'sailcms',
            'adapters' => [
                Database::class
            ],
            'datadog' => [
                'api_key_identifier' => 'DD_DEFAULT_KEY'
            ],
            'minLevel' => Level::Debug,
            'bubble' => true
        ],
        'assets' => [
            'adapter' => 's3',
            'optimizeOnUpload' => true,
            'transformOutputFormat' => 'webp',
            'transformQuality' => 92, // 92%
            'maxUploadSize' => 5, // in MB
            'onUploadTransforms' => [
                'thumbnail' => ['width' => 100, 'height' => 100, 'crop' => Transformer::CROP_CC]
            ]
        ],
        'entry' => [
            'defaultType' => [
                'title' => 'Page',
                'urlPrefix' => [
                    'fr' => 'abc',
                    'en' => 'efg'
                ],
                'entryLayoutId' => '639359dc2ce8dcaf4a06e090'
            ]
        ]
    ]
];