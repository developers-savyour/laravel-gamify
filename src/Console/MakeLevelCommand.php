<?php

namespace QCod\Gamify\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Cache;

class MakeLevelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamify:level {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Gamify badge class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Level';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/level.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace The root namespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Classes\Gamify\Levels';
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        // clear the cache for badges
        Cache::forget('gamify.level.all');

        return parent::handle();
    }


}
