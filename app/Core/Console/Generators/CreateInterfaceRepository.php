<?php

namespace App\Core\Console\Generators;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class CreateInterfaceRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:repository:interface';

    /**
     * @var string
     */
    protected $type = 'RepositoryInterface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to create a RepositoryInterface with create:repository command';

    public function fire()
    {
        $model = str_replace('RepositoryInterface', '', $this->getNameInput());
        
        $domain = Str::plural($model);

        $defaultRoot = 'App\\Domains\\' . $domain . '\\Repositories\\' . $this->getNameInput();

        $name = $this->parseName($defaultRoot);

        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');
    }


    protected function getStub()
    {
        return storage_path('/app/stubs/repositoryInterface.stub');
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceInterface($stub)
                    ->replaceNamespace($stub, $name)
                    ->replaceClass($stub, $name);
    }

    public function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            '{$NAMESPACE}', $this->getNamespace($name), $stub
        );

        $stub = str_replace(
            'DummyRootNamespace', $this->laravel->getNamespace(), $stub
        );

        return $this;
    }
    
    public function replaceInterface(&$stub)
    {

        $stub = str_replace('{$INTERFACE}', $this->getNameInput(), $stub);

        return $this;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the RepositoryInterface.'],
        ];
    }

}
