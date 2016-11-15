<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;

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
     * Write the migration file to disk.
     *
     * @param  string  $name
     * @param  string  $table
     * @param  bool    $create
     * @return string
     */
    protected function writeMigration($name, $table, $create)
    {
        $path = $this->getMigrationPath();
        $full_file = $this->creator->create($name, $path, $table, $create);

        $file = pathinfo($full_file, PATHINFO_FILENAME);

        $this->line("<info>Created Migration:</info> $file");

        exec("$this->bin $full_file");
    }

}
