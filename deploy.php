<?php
namespace Deployer;

require 'recipe/common.php';

date_default_timezone_set('Europe/Amsterdam');

inventory('servers.yml');
set('default_stage', 'staging');

// Project name
set('application', 'My Boilerplate App');

set('allow_anonymous_stats', false);

// Specify the repository from which to download your project's code.
// The server needs to have git installed for this to work.
// If you're not using a forward agent, then the server has to be able to clone
// your project from this repository.
set('repository', 'git@gitlab.digitalnatives.nl:xxx/xxx.git');
set('repository_url', 'https://gitlab.digitalnatives.nl/xxx/xxx');

// Craft shared dirs
set('shared_dirs', ['craft/storage', 'craft/web/cpresources']);

// Craft shared file
set('shared_files', ['craft/.env', 'craft/config/license.key']);

// Craft writable dirs
set('writable_dirs', ['craft/storage', 'craft/vendor', 'craft/config']);

set('project_dir', 'craft');

/**
 * Installing vendors tasks.
 */
task('deploy:vendors', function () {
    if (commandExist('{{release_path}}/craft/composer.phar')) {
        $composer = 'php {{release_path}}/craft/composer.phar';
    } elseif (commandExist('composer')) {
        $composer = 'composer';
    } else {
        run("cd {{release_path}}// && curl -sS https://getcomposer.org/installer | php");
        $composer = 'php composer.phar';
    }

    $composerEnvVars = get('env') ? 'export ' . get('env') . ' &&' : '';
    run("cd {{release_path}}/craft && $composerEnvVars $composer {{composer_options}} -v");

})->desc('Installing vendors');

task('deploy:clear_cache', function()
{
    run("php {{release_path}}/craft/vendor/bin/cachetool opcache:reset --fcgi={{fcgi_path}}");
    run("php {{release_path}}/craft/craft cache/flush-all");
});

task('database:migrate', function()
{
    run("cd {{release_path}}/craft && ./craft migrate/all");
    run("cd {{release_path}}/craft && ./craft project-config/sync --interactive=0");
});

task('notify:bugsnag', function(){
    $stage = get('stage');
    $repository = get('repository_url');
    $tag = getenv('CI_COMMIT_TAG');

    $version = $stage === 'production' ? $tag : date('Y-m-d H:i:s');

    runLocally(
        'curl -sS \
           --request POST \
           --header "Content-Type: application/json" \
           --data-binary "{
               \"apiKey\": \"$BUGSNAG_API_KEY\",
               \"appVersion\": \"' . $version . '\",
               \"builderName\": \"deployer\",
               \"sourceControl\": {
                   \"provider\": \"gitlab-onpremise\",
                   \"repository\": \"' . $repository . '\",
                   \"revision\": \"$CI_COMMIT_SHA\"
               },
               \"releaseStage\": \"' . $stage . '\",
               \"autoAssignRelease\": true
               }" \
           \'https://build.bugsnag.com/\''
    );
});

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'database:migrate',
    'deploy:symlink',
    'deploy:clear_cache',
    'notify:bugsnag',
    'cleanup',
])->desc('Deploy your project');
