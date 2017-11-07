<?php

namespace Database;

/**
 * Description of ExpressionTable
 *
 * @author NewEXE
 */
class ExpressionTable {

    private $_pdo;

    public function __construct($dbParams) {
        try {
            $this->_pdo = new \PDO($dbParams['dsn'], $dbParams['user'], $dbParams['pass']);
            $this->createTableIfNotExists();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function createTableIfNotExists() {
        $this->_pdo->query('CREATE TABLE IF NOT EXISTS expressions
                (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `expression` VARCHAR(64)
                );'
        )->execute();
    }

    public function truncateTable() {
        $this->_pdo->query("TRUNCATE TABLE expressions");
    }

    public function insertData($expressions) {
        $this->truncateTable();
        foreach ($expressions as $expression) {
            $stmt = $this->_pdo->prepare('INSERT INTO expressions'
                    . '(`expression`) VALUES(?)');
            $stmt->execute([$expression]);
        }
    }

    public function selectData() {
        $data = [];
        foreach ($this->_pdo->query('SELECT `expression` FROM expressions', \PDO::FETCH_NUM) as $row)
            $data[] = $row;
        
        $data = call_user_func_array('array_merge', $data);
        return $data;
    }

}
