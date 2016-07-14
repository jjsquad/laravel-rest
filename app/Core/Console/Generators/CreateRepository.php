<?php

namespace App\Core\Console\Generators;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class CreateRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:repository';

    /**
     * @var string
     */
    protected $type = 'Repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository with: Model, Repository Class and Repository Interface';

    /**
     * Get the full domain name (pluralized)
     * @return string
     */
    public function getDomain()
    {
        return 'App\\Domains\\' . Str::plural($this->getNameInput());
    }
    
    public function fire()
    {
        $repoName = $this->getNameInput() . 'RepositoryEloquent';
            
        $this->call('make:model', [
            'name' => $this->getDomain() . '\\' . $this->getNameInput()
        ]);

        $repoPath = $this->getDomain()  . '\\Repositories\\' . $repoName;

        $name = $this->parseName($repoPath);

        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');

        $this->call('create:repository:interface', [
            'name' => $this->getNameInput() . 'RepositoryInterface'
        ]);
    }

    protected function getStub()
    {
        return storage_path('/app/stubs/repository.stub');
    }

    protected function getNameInput()
    {
        return trim($this->argument('model'));
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceModel($stub)
                    ->replaceDefaultPath($stub)
                    ->replaceInterface($stub)
                    ->replaceNamespace($stub, $name)
                    ->replaceClass($stub, $name);
    }
    
    public function replaceDefaultPath(&$stub)
    {
        $stub = str_replace('{$MODEL_PATH}', $this->getDomain(), $stub);
        
        return $this;
    }

    public function replaceInterface(&$stub)
    {
        $interface = $this->getNameInput() . 'RepositoryInterface';
        
        $stub = str_replace('{$INTERFACE}', $interface, $stub);
        
        return $this;
    }
    
    public function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('{$CLASS}', $class, $stub);
        
    }

    public function replaceModel(&$stub)
    {
        $stub = str_replace('{$MODEL}', $this->getNameInput(), $stub);
        
        return $this;
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

    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'The name of the Repository.']
        ];
    }

}
