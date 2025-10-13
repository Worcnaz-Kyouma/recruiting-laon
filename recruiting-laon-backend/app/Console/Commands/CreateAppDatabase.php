<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAppDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'That command creates the application database';

    public function handle(): void {
        $database = env('DB_DATABASE');
        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        try {
            $pdo = new \PDO("mysql:host=$host", $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`");
            $this->info("Database '$database' created successfully.");
        } catch (\PDOException $e) {
            $this->error("Error creating database: " . $e->getMessage());
        }
    }
}
