<?php

namespace Helper;

use Codeception\Module\Db;
use PDOException;

/**
 * Class DbHelper
 *
 * @package AdNet
 */
class DbHelper extends \Codeception\Module
{
    /**
     * Run all sql files in a given directory.
     *
     * @param string|null $dir
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function runSqlQueries($dir = null)
    {
        if (!is_null($dir)) {

            /**
             * @var Db $dbh
             */
            $dbh = $this->getModule('Db');

            /*
             * Get all the queries in the directory
             */
            foreach (glob('tests/_data/' . $dir . '/*.sql') as $sqlFile) {
                try {
                    $dbh->driver->load(file($sqlFile));
                } catch (PDOException $e) {
                    $error = sprintf(
                        'Invalid SQL command in patch file %s. [Error: %s]',
                        $sqlFile,
                        $e->getMessage()
                    );

                    $this->fail($error);
                }
            }
        }
    }
}
