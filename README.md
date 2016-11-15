# Laravel 5 Phpstorm Migration Opener

Auto open migrations in editor window after creation in the PhpStorm internal terminal.

# Installation

1. Within PhpStorm select 'Tools/Create Command-line Launcher'
2. Choose a name for your launcher (pstorm is the default on my machine)
3. Copy the PsMigration.php class into 'app/Console/Commands' and register it in the 'app/Console/Kernel.php' file
4. Change the $bin property in PsMigration.php to whatever you called your launcher in step 2
5. Run php artisan:list to check to command is registered correctly - the default name is make:pmigration
6. Use in the same way as make:migration but now the file will open automatically in PhpStorm

Tested with Laravel 5.2.45 and PhpStorm 2016.2.2 Build #PS-162.2380.11 on OS X


