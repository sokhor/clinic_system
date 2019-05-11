<?php

namespace App\Console\Commands;

use Illuminate\Database\Console\Factories\FactoryMakeCommand as Command;

class FactoryMakeCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'module:make:factory {name : The name of the migration.}
                                {--path= : The location where the migration file should be created.}
                                {--model=MODEL : The name of the model.}';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace(
            ['\\', '/'],
            '',
            $this->argument('name')
        );

        if ($this->option('path')) {
            return $this->option('path') . "/factories/{$name}.php";
        }

        return $this->laravel->databasePath() . "/factories/{$name}.php";
    }
}
