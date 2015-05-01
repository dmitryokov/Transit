<?php
namespace Kenarkose\Transit\Console;


use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class CreateModelCommand extends Command {

    use AppNamespaceDetectorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'transit:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Transit model';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'Name of the model.'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $name = $this->argument('name');

        $this->line('');
        $this->info('Model name: ' . $name);

        $this->comment(
            'A model that extends the default Kenarkose\Transit\Model\File'
            . ' model will be created in app directory.'
        );
        $this->line('');

        $this->info("Creating model...");
        if ($this->createModel($name))
        {
            $this->info("Model successfully created!");

            $this->promptMigration($name);
        } else
        {
            $this->error(
                "Coudn't create model.\n Check the write permissions" .
                " within the app directory."
            );
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function createModel($name)
    {
        $namespace = $this->getNamespace();
        $vars = compact('namespace', 'name');

        $filepath = app_path() . '/' . $name . '.php';

        $output = view('_transit::model', $vars)->render();

        if ( ! file_exists($filepath))
        {
            $fs = fopen($filepath, 'x');
            if ($fs)
            {
                fwrite($fs, $output);
                fclose($fs);

                return true;
            } else
            {
                return false;
            }
        } else
        {
            return false;
        }
    }

    /**
     * Returns the current app namespace
     *
     * @return string
     */
    protected function getNamespace()
    {
        return rtrim($this->getAppNamespace(), '\\');
    }

    /**
     * Prompts for migration
     *
     * @param $name
     */
    protected function promptMigration($name)
    {
        $this->line('');

        if ($this->confirm('Would you like to create the migration for the model? [Yes|no]'))
        {
            $this->call('transit:migration', ['table' => str_plural($name)]);
        }
    }

}
