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
        $base_dir = base_path('modules' . DIRECTORY_SEPARATOR);
        $this->singular_name = str_singular($this->argument('name'));
        $this->plural_name = $this->argument('name');

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
        
        mkdir($base_dir . studly_case($this->plural_name));
        
        foreach ($directories as $directory) {
            mkdir($base_dir . studly_case($this->plural_name) . '/' . $directory);
        }
        
        $origin = $base_dir.'Bake/bake_template/';
        
        $this->createFile($origin . '/Controllers/Controller.php', $base_dir . studly_case($this->plural_name) . '/Controllers/' . studly_case($this->plural_name) . 'Controller.php');
        $this->createFile($origin . '/Providers/ServiceProvider.php', $base_dir . studly_case($this->plural_name) . '/Providers/' . studly_case($this->singular_name) . 'ServiceProvider.php');
        $this->createFile($origin . '/Routes/api.php', $base_dir . studly_case($this->plural_name) . '/Routes/api.php');
        $this->createFile($origin . '/Routes/web.php', $base_dir . studly_case($this->plural_name) . '/Routes/web.php');
        $this->createFile($origin . '/Views/index.blade.php', $base_dir . studly_case($this->plural_name) . '/Views/index.blade.php');
        
        $this->output->writeln([
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
        file_put_contents($destiny, $content);
    }
}
