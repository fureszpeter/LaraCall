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
    protected $signature = 'migrate:db {--F|table-filter=cc_% : Filter for table}';

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
        $filter = $this->option('table-filter');

        $sourceDb = $this->ask('What is the source db?', 'mya2billing');
        $targetDb = $this->ask('What is the original (new, untouched, target) database?', 'a2billing');

        $query = $pdo->query("SHOW TABLES IN {$targetDb} LIKE '{$filter}'");

        $tables = $query->fetchAll();

        $tables = array_map(function (array $row) {
            return $row[0];
        }, $tables);

        foreach ($tables as $tableName) {
            if ($this->confirm("Do you want a migrate [table: `{$tableName}`] (target table will be deleted!)?", true)) {

                $this->info("Deleting table data `{$targetDb}`.`{$tableName}`");
                $numberOfDeletedRows = $this->deleteTableData($pdo, $targetDb, $tableName);
                $this->info("Deleted {$numberOfDeletedRows} from `{$targetDb}`.`{$tableName}`");

                $this->info("Migrating {$tableName}");
                $numberOfInsertedRows = $this->migrate($sourceDb, $targetDb, $tableName, $pdo);
                $this->info("Inserted {$numberOfInsertedRows} to `{$targetDb}`.`{$tableName}`");
                $this->output->writeln('================');
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
     *
     * @return int
     */
    protected function migrate(string $sourceDb, string $targetDb, string $tableName, PDO $pdo)
    {
        $targetColumns = $this->getColumnNames($pdo, $targetDb, $tableName);

        $escapedFields = array_map(function (string $field){
            return "`{$field}`";
        }, $targetColumns);

        $implodedFields = implode(', ', $escapedFields);

        $sql = "INSERT INTO `{$targetDb}`.{$tableName}({$implodedFields})"
            . "\n"
            . "SELECT {$implodedFields} FROM `{$sourceDb}`.`$tableName`;";

        if ($this->option('verbose')){
            $this->info($sql);
        }

        $insert = $pdo->prepare($sql);
        $insert->execute();

        return $insert->rowCount();

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

    /**
     * @param PDO    $pdo
     * @param string $targetDb
     * @param string $tableName
     *
     * @return int
     */
    private function deleteTableData(PDO $pdo, string $targetDb, string $tableName)
    {
        $sql = "DELETE FROM `{$targetDb}`.{$tableName};";
        $query = $pdo->prepare($sql);
        $query->execute();

        return $query->rowCount();
    }
}
