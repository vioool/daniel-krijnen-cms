<?php

/**
 * Bugsnag plugin for Craft CMS 3.x
 *
 * Log Craft errors/exceptions to Bugsnag.
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
*/

return [
    // Enable exception logging
    'enabled' => true,
    // Project API key
    'serverApiKey' => getenv('BUGSNAG_API_KEY'),
    // Release stage
    'releaseStage' => getenv('ENVIRONMENT'),
    // App version
    'appVersion' => '',
    // Release stages to log exceptions in
    'notifyReleaseStages' => ['staging', 'production'],
    // Sensitive attributes to filter out, like 'password'
    'filters' => [],
    // Metadata to send with every request
    'metaData' => [],
    // Blacklist certain exception types like 404s
    'blacklist' => [
        [
            'label' => '404 and 503',
            'class' => static function ($exception) {
                return !($exception instanceof \yii\web\HttpException &&
                    ($exception->statusCode === 404 || $exception->statusCode === 503)
                );
            },
        ],
    ],
];
