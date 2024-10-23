<?php


class Migration
{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $conn;

    public function __construct($dbname = 'engpproject', $host = 'localhost', $user = 'root', $pass = '')
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->connect();
    }

    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function createDatabase($dbname)
    {
        try {
            $this->conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
    
            if ($this->conn->select_db($dbname)) {
                echo "Database $dbname created successfully\n";
            } else {
                echo "Error creating database: " . $this->conn->error . "\n";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1007) { // Database already exists
                echo "Database $dbname already exists\n";
            } else {
                echo "Error creating database: " . $e->getMessage() . "\n";
            }
        }
    }

    public function create($table, $callback)
    {
        $startTime = microtime(true);

        $this->conn->select_db($this->dbname);

        $blueprint = new Blueprint($this->conn);
        $callback($blueprint);

        $query = "CREATE TABLE IF NOT EXISTS $table (";
        $query .= implode(", ", $blueprint->getFields());
        $query .= ")";

        if ($this->conn->query($query) === true) {

            $endTime = microtime(true);
            echo "Table $table created successfully in database $this->dbname\n";
            echo "Time taken: " . ($endTime - $startTime) . " seconds\n";
            echo "--------------------------------------------\n";
        } else {
            echo "Error creating table: " . $this->conn->error . "\n";
        }
    }

    public function alter($table, $callback)
    {
        $this->conn->select_db($this->dbname);

        $blueprint = new Blueprint($this->conn, $table);
        $callback($blueprint);

        $query = "ALTER TABLE $table ";
        $query .= implode(", ", $blueprint->getFields());

        if ($this->conn->query($query) === true) {
            echo "Table $table altered successfully in database $this->dbname\n";
        } else {
            echo "Error altering table: " . $this->conn->error . "\n";
        }
    }

    public function drop($table)
    {
        $this->conn->select_db($this->dbname);

        $query = "DROP TABLE IF EXISTS $table";

        if ($this->conn->query($query) === true) {
            echo "Table $table dropped successfully from database $this->dbname\n";
        } else {
            echo "Error dropping table: " . $this->conn->error . "\n";
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function insert($table, $data)
    {
        $this->conn->select_db($this->dbname);

        $fields = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";

        $query = "INSERT INTO $table ($fields) VALUES ($values)";

        if ($this->conn->query($query) === true) {
            echo "Record inserted successfully in table $table\n";
        } else {
            echo "Error inserting record: " . $this->conn->error . "\n";
        }
    }
}
