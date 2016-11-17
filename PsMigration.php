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
     */
    protected function writeMigration($name, $table, $create)
    {
        parent::writeMigration($name, $table, $create);

        $migrationPath = $this->getMigrationPath();
        $latestMigration = $this->getLastMigration($migrationPath);

        if($latestMigration !== ''){
            exec("$this->bin ".escapeshellarg($migrationPath.DIRECTORY_SEPARATOR.$latestMigration));
        }
    }

    /**
     * Returns the latest file created in the $migration_path directory
     *
     * @param string $migration_path
     * @return string
     */
    protected function getLastMigration($migration_path)
    {
        $time_placeholder = 0;
        $latest_migration = '';

        foreach (new DirectoryIterator($migration_path) as $file) {
            $created_time = $file->getCTime();
            $filename = $file->getFilename();

            //Exclude the parent directory from the comparison
            if ($filename !== '.') {
                if ($created_time > $time_placeholder) {
                    $time_placeholder = $created_time;
                    $latest_migration = $filename;
                }
            }
        }

        return $latest_migration;
    }
}