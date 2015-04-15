<?php
namespace Kenarkose\Transit\Console;


use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateMigrationCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'transit:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the default Transit migration';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'Name of the table.'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $table = $this->argument('table');

        $this->line('');
        $this->info('Migration table: ' . $table);

        $this->comment(
            'A migration that will create the default files table'
            . ' for Transit will be created in database/migrations directory.'
        );
        $this->line('');

        $this->info("Creating migration...");
        if ($this->createMigration($table))
        {
            $this->info("Migration successfully created!");

            $this->promptMigrate();
        } else
        {
            $this->error(
                "Coudn't create migration.\n Check the write permissions" .
                " within the database/migrations directory."
            );
        }
    }

    /**
     * @param string $table
     * @return bool
     */
    protected function createMigration($table)
    {
        $table = strtolower($table);

        $filepath = base_path() . '/database/migrations/' . date('Y_m_d_His'). '_transit_create_' . $table . '_table.php';

        $output = view('_transit::migration', ['table' => $table])->render();

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
     * Prompts for migration
     */
    protected function promptMigrate()
    {
        $this->line('');

        if ($this->confirm('Would you like to migrate database? [Yes|no]'))
        {
            $this->call('migrate');
        }
    }

}
