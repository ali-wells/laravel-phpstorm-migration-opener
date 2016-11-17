<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use DirectoryIterator;

class PsMigration extends MigrateMakeCommand
{
    protected $bin = 'pstorm';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:pmigration {name : The name of the migration.}
        {--create= : The table to be created.}
        {--table= : The table to migrate.}
        {--path= : The location where the migration file should be created.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file and auto-open in PhpStorm';

    /**
     * Write the migration file to disk and open in the current PhpStorm session
     *
     * @param  string  $name
     * @param  string  $table
     * @param  bool    $create
     * @return string
     */
    protected function writeMigration($name, $table, $create)
    {
        parent::writeMigration($name, $table, $create);

        $migration_path = $this->getMigrationPath();
        $latest_migration = $this->getLastMigration($migration_path);

        if($latest_migration !== ''){
            exec("$this->bin ".escapeshellarg($migration_path.DIRECTORY_SEPARATOR.$latest_migration));
        }
    }

    function getLastMigration($migration_path)
    {
        $time_placeholder = 0;
        $latest_migration = '';

        foreach (new DirectoryIterator($migration_path) as $file) {
            //Exclude the parent directory
            if ($file->getFilename() !== '.') {
                $created_time = $file->getCTime();    // Time file was created
                $filename = $file->getFilename(); // File name
                if ($created_time > $time_placeholder) {
                    $time_placeholder = $created_time;
                    $latest_migration = $filename;
                }
            }
        }

        return $latest_migration;
    }

}
