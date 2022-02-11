<?php

/**
 * Yii Application Config
 *
 * Edit this file at your own risk!
 *
 * The array returned by this file will get merged with
 * vendor/craftcms/cms/src/config/app/main.php and [web|console].php, when
 * Craft's bootstrap script is defining the configuration for the entire
 * application.
 *
 * You can define custom modules and system components, and even override the
 * built-in system components.
 */

use superbig\bugsnag\Bootstrap;

return [
    'bootstrap' => [Bootstrap::class],
    'components' => [
        'cache' => [
            'class' => yii\redis\Cache::class,
            'defaultDuration' => 86400,
            'redis' => [
                'class' => yii\redis\Connection::class,
                'hostname' => getenv('REDIS_HOST'),
                'port' => getenv('REDIS_PORT'),
                //  If a unix socket path is specified, [[hostname]] and [[port]] will be ignored.
                'unixSocket' => getenv('REDIS_SOCKET'),
                'database' => getenv('REDIS_DB'),
            ],
        ],
    ],
];
