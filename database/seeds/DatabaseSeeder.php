<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $migrator = app('migrator');
        $db = $migrator->resolveConnection(null);
        $migrations = $migrator->getMigrationFiles('database/migrations');
        $queries = [];

        foreach($migrations as $migration) {
            $migration_name = $migration;
            $migration = $migrator->resolve($migration);

            $queries[] = [
                'name' => $migration_name,
                'queries' => array_column($db->pretend(function() use ($migration) { $migration->up(); }), 'query'),
            ];
        }

    }
}
