<?php
/**
 * User: Tom2017 Date: 8/5/2018 Time: 12:04 PM
 */

namespace WebAppFramework\Db;

/**
 * Class Db
 *
 * PDO Wrapper to make common things less verbose for dealing with general associative arrays
 *
 * @package WebAppFramework\Db
 */
class Db
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Shortcut around PDO's verbose access
     *
     * @param $sql
     * @param array $bindings
     * @return \PDOStatement
     */
    public function execute($sql, $bindings = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindings);
        return $stmt;
    }
}