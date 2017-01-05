<?php

namespace LaraCall\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class MigrateDbCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import modified db to original db';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param PDO $pdo
     *
     * @return mixed
     */
    public function handle(PDO $pdo)
    {
        $sourceDb = $this->ask('What is the source db?', 'mya2billing');
        $targetDb = $this->ask('What is the original (new, untouched, target) database?', 'a2billing');

        $query = $pdo->query("SHOW TABLES IN {$targetDb} LIKE 'cc_%'");

        $tables = $query->fetchAll();

        $tables = array_map(function (array $row) {
            return $row[0];
        }, $tables);

        foreach ($tables as $tableName) {
            if ($this->confirm("Do you want a migrate [table: `{$tableName}`]?", true)) {
                $this->info("Migrating {$tableName}");
                $this->migrate($sourceDb, $targetDb, $tableName, $pdo);
            }
        }

        $source = $this->choice(
            'Which source would you like to use?',
            ['master', 'develop']
        );

        $this->info("Source chosen is $source");
    }

    /**
     * @param string $sourceDb
     * @param string $targetDb
     * @param string $tableName
     * @param PDO    $pdo
     */
    protected function migrate(string $sourceDb, string $targetDb, string $tableName, PDO $pdo)
    {
        $sourceColumns = $this->getColumnNames($pdo, $sourceDb, $tableName);

        $escapedFields = array_map(function (string $field){
            return "`{$field}`";
        }, $sourceColumns);

        $implodedFields = implode(', ', $escapedFields);

        $sql = "INSERT INTO `{$targetDb}`.{$tableName}({$implodedFields})"
            . "\n"
            . " SELECT {$implodedFields} FROM `{$sourceDb}`.$tableName;";

        $this->info($sql);
    }

    /**
     * @param PDO    $pdo
     * @param string $dbName
     * @param string $tableName
     *
     * @return array
     */
    protected function getColumnNames(PDO $pdo, string $dbName, string $tableName) : array
    {
        $sql = "SHOW COLUMNS FROM `{$dbName}`.{$tableName};";
        $query = $pdo->query($sql);

        $columnNames = $query->fetchAll();
        $columnNames = array_map(function (array $columnDefinitions){
            return $columnDefinitions['Field'];
        }, $columnNames);

        return $columnNames;
    }
}
