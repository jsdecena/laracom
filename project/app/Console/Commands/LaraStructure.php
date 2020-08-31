<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LaraStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:structure {model} {--m|migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generate model and a base repository out of the box.';

    /**
     * Filesystem instance
     * 
     * @var string
     */
    protected $filesystem;

    /**
     * Default laracom folder
     * 
     * @var string
     */
    protected $folder;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get model name from developer
        $this->model = ucfirst($this->argument('model'));

        // Get plural name for the given model
        $pluralModel = str_plural($this->model);

        // Check if the model already created
        if ( $this->filesystem->exists(app_path("Shop/{$pluralModel}/{$this->model}.php")) ){
            return $this->error("The given model already exists!");
        }

        // create all structured folders
        $this->createFolders('Shop');

        $this->createFile(
            app_path('Console/Stubs/DummyRepository.stub'),
            app_path("Shop/{$pluralModel}/Repositories/{$this->model}Repository.php")
        );

        $this->createFile(
            app_path('Console/Stubs/DummyRepositoryInterface.stub'),
            app_path("Shop/{$pluralModel}/Repositories/Interfaces/{$this->model}RepositoryInterface.php")
        );

        $this->info('File structure for ' . $this->model . ' created.');
        
        // Create Model under default instalation folder
        $this->call('make:model', [
            'name' => 'Shop/' . $pluralModel . '/' .$this->model,
            '--migration' => $this->option('migration'),
        ]);
    }

    /**
     * Create source from dummy model name
     * 
     * @param  string $dummy        
     * @param  string $destinationPath
     * @return void
     */
    protected function createFile($dummySource, $destinationPath)
    {
        $pluralModel = str_plural($this->model);
        $dummyRepository = $this->filesystem->get($dummySource);
        $repositoryContent = str_replace(['Dummy', 'Dummies'], [$this->model, $pluralModel], $dummyRepository);
        $this->filesystem->put($dummySource, $repositoryContent);
        $this->filesystem->copy($dummySource, $destinationPath);
        $this->filesystem->put($dummySource, $dummyRepository);
    }

    /**
     * Create all required folders
     * 
     * @return void
     */
    protected function createFolders($baseFolder)
    {
        // get plural from model name
        $pluralModel = str_plural($this->model);
         // create container folder
        $this->filesystem->makeDirectory(app_path($baseFolder."/{$pluralModel}"));
         // add requests folder
        $this->filesystem->makeDirectory(app_path($baseFolder."/{$pluralModel}/Requests"));
         // add repositories folder
        $this->filesystem->makeDirectory(app_path($baseFolder."/{$pluralModel}/Repositories/"));
         // add Interfaces folder
        $this->filesystem->makeDirectory(app_path($baseFolder."/{$pluralModel}/Repositories/Interfaces"));
    }
}
