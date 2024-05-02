<?php

namespace Database\utils;

use Exception;
use PDO;
use PDOException;

class DB
{
    // Private Variables
    public PDO $pdo;
    private static mixed $instance = null;

    /**
     * Constructor reads Database credentials from file and connects to it using pdo
     * @param string $file
     * @throws Exception
     */
    private final function __construct(string $file = "settings.ini")
    {
        // Using a separate file where we keep the DB parameters for improved security
        try {
            // If the file exists
            if (file_exists($file)) {
                // We parse through it
                $settings = parse_ini_file($file);
            } else {
                // If the file does not exist then throw an Exception
                throw new Exception("File $file does not exist!");
            }
        } catch (Exception $e) {
            throw new Exception("Unable to open $file\t" . $e->getMessage());
        }

        try {
            $dsn = "{$settings["driver"]}:dbname={$settings["dbname"]};host={$settings["host"]};port={$settings["port"]}";
            // Make the DB connection
            $this->pdo = new PDO($dsn, $settings["user"], $settings["password"]);

            print("DB started successfully!\n");
        } catch (PDOException $e) {
            throw new Exception("Error when starting DB!:\t" . $e->getMessage());
        }
    }

    /**
     * Singleton instance
     * @return mixed|null
     */
    public static function getInstance(): mixed
    {
        if (null === self::$instance) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    /**
     * Executes the given query on the DB and returns all the results/rows
     * @param string $sql
     * @return false|array
     */
    public function select(string $sql): false|array
    {
        $sth = $this->pdo->query($sql);
        return $sth->fetchAll();
    }

    /**
     * Prepares and executes the query on the DB
     * @param string $sql
     * @param array $exec_arg
     * @param bool $delete
     * @return bool
     */
    public function exec(string $sql, array $exec_arg, bool $delete = false): bool
    {
        // Prepare the SQL query
        $prepared_sql = $this->pdo->prepare($sql);
        // Execute the SQL query
        $execute_response = $prepared_sql->execute($exec_arg);

        // If the functions is used to execute a DELETE query
        if ($delete) {
            // Check the rowCount of the DB to see if the row was deleted or not
            // as it is possible that the provided ID does not exist in the DB
            return $prepared_sql->rowCount();
        } else {
            return $execute_response;
        }
    }

    /**
     * Returns the last inserted ID in the Database
     * @return false|string
     */
    public function getLastInsertId(): false|string
    {
        return $this->pdo->lastInsertId();
    }
}

