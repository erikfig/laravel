<?php

namespace Modules\Bake\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BakeCommand extends Command
{
    protected $signature = 'bake:module {name}';
    protected $description = 'Create a new module skeleton, use the plural name in lowercase and underscore separator';

    protected $singular_name;
    protected $plural_name;

    public function handle()
    {
        $base_dir = base_path(config('modules.basePath') . DIRECTORY_SEPARATOR);
        $this->singular_name = str_singular($this->argument('name'));
        $this->plural_name = $this->argument('name');
        $module_dir = $base_dir . studly_case($this->plural_name);

        if (!is_dir($base_dir)) {
            mkdir($base_dir);
        }

        if (is_dir($base_dir . $this->argument('name'))) {
            throw new \Exception('This modules exists!');
        }

        $directories = [
            'Controllers',
            'Providers',
            'Routes',
            'Views',
        ];

        $files = [
            'controller' => 'Controller.php',
            'provider' => 'ServiceProvider.php',
            'route' => [
                'api.php',
                'web.php',
            ],
            'view' => 'index.blade.php',
        ];

        mkdir($module_dir);
        $module_dir = $base_dir . studly_case($this->plural_name) . DIRECTORY_SEPARATOR . 'src';
        mkdir($module_dir);

        foreach ($directories as $directory) {
            mkdir($module_dir . '/' . $directory);
        }

        $origin = base_path('modules').'/Bake/bake_template';

        $this->createFile($origin . '/Controllers/Controller.php', $module_dir . '/Controllers/' . studly_case($this->plural_name) . 'Controller.php');
        $this->createFile($origin . '/Providers/ServiceProvider.php', $module_dir . '/Providers/' . studly_case($this->singular_name) . 'ServiceProvider.php');
        $this->createFile($origin . '/Routes/api.php', $module_dir . '/Routes/api.php');
        $this->createFile($origin . '/Routes/web.php', $module_dir . '/Routes/web.php');
        $this->createFile($origin . '/Views/index.blade.php', $module_dir . '/Views/index.blade.php');

        $this->output->writeln([
            'Add autoload to composer.json:',
            '"autoload": {',
            '    "psr-4": {',
            '        "' .config('modules.vendorName'). '\\\\' . studly_case($this->plural_name) . '\\\\": "' .config('modules.basePath'). '/' . studly_case($this->plural_name) . '/src/"',
            '    }',
            '},',
            '',
            'Add this provider to config/app.php:',
            'Modules\\' . studly_case($this->plural_name) . '\Providers\\' . studly_case($this->singular_name) . 'ServiceProvider::class,'
        ]);
    }

    protected function createFile($origin, $destiny)
    {
        $content = file_get_contents($origin);
        $content = str_replace("{{plural-upper}}", studly_case($this->plural_name), $content);
        $content = str_replace("{{plural-lower}}", $this->plural_name, $content);
        $content = str_replace("{{singular-upper}}", studly_case($this->singular_name), $content);
        $content = str_replace("{{singular-lower}}", $this->singular_name, $content);
        $content = str_replace("{{vendor-name}}", config('modules.vendorName'), $content);
        file_put_contents($destiny, $content);
    }
}
