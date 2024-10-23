<?php


class Blueprint
{
    private $fields = [];
    private $currentField = '';
    private $connection;

    private $table;

    //construct
    public function __construct($connection, $table = null)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function id()
    {
        $this->currentField = 'id INT AUTO_INCREMENT PRIMARY KEY';
        $this->fields[] = $this->currentField;
    }

    public function string($name, $length = 255)
    {
        $this->currentField = "$name VARCHAR($length) NOT NULL";
        $this->fields[] = $this->currentField;

        return $this;
    }

    public function text($name)
    {
        $this->currentField = "$name TEXT NOT NULL";
        $this->fields[] = $this->currentField;
        return $this;
    }
    public function date($name)
    {
        $this->currentField = "$name DATE NOT NULL";
        $this->fields[] = $this->currentField;
        return $this;
    }

    public function integer($name, $length = 11)
    {
        $this->currentField = "$name INT($length) NOT NULL";
        $this->fields[] = $this->currentField;
        return $this;
    }

    public function biginteger($name, $length = 20)
    {
        $this->currentField = "$name BIGINT($length) NOT NULL";
        $this->fields[] = $this->currentField;
        return $this;
    }


    public function decimal($name, $length = '10,2')
    {
        $this->currentField = "$name DECIMAL($length) NOT NULL";
        $this->fields[] = $this->currentField;
        return $this;
    }

    public function tinyint($name, $length = 4)
    {
        $this->currentField = "$name TINYINT($length) NOT NULL";
        $this->fields[] = $this->currentField;
        return $this;
    }

    public function boolean($name)
    {
        $this->currentField = "$name BOOLEAN NOT NULL";
        $this->fields[] = $this->currentField;
        return $this;
    }

    public function nullable()
    {



        foreach ($this->fields as &$field) {
            // If the current field matches, modify it
            if (strpos($field, $this->currentField) !== false) {
                // Remove "NOT NULL" constraint
                $field = str_replace('NOT NULL', '', $field);


                // Add or update "NULL" constraint
                if (strpos($field, 'NULL') === false) {
                    $field .= ' NULL';
                } else {
                    $field = str_replace('NULL', '', $field);
                    $field .= ' NULL';
                }
            }
        }

        return $this;
    }

    public function default($value)
    {

        foreach ($this->fields as &$field) {
            // If the current field matches, modify it
            if (strpos($field, $this->currentField) !== false) {
                // Add or update "DEFAULT" constraint
                if (strpos($field, 'DEFAULT') === false) {
                    // If there's no DEFAULT constraint, add it
                    $field .= " DEFAULT '$value'";
                } else {
                    // If there's already a DEFAULT constraint, ensure it's positioned correctly
                    $field = str_replace('DEFAULT', '', $field);
                    $field .= " DEFAULT '$value'";
                }
            }
        }

        return $this;
    }

    public function timestamps()
    {
        $this->fields[] = 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        $this->fields[] = 'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
    }

    public function getFields()
    {

        return $this->fields;
    }
    public function columnExists($name)
    {
        $query = "SHOW COLUMNS FROM $this->table LIKE '$name'";
        $result = $this->connection->query($query);
        return $result->num_rows > 0;
    }

    public function addColumn($name, $type, $after = null)
    {

        if ($this->columnExists($name)) {
            return $this;
        }

        if ($after) {
            $this->currentField = "ADD COLUMN `$name` $type NOT NULL AFTER `$after` ";
        } else {
            $this->currentField = "ADD COLUMN `$name` $type NOT NULL";
        }

        $this->fields[] = $this->currentField;
        return $this;
    }

    public function onUpdate()
    {
        $this->currentField = "ON UPDATE CURRENT_TIMESTAMP";
        $this->fields[] = $this->currentField;
        return $this;
    }


    public function rawQuery($query, $name = null)
    {

        if ($this->columnExists($name)) {
            return $this;
        }

        $this->fields[] = $query;
        return $this;
    }





    public function addNullColumn($name, $type, $after = null)
    {

        if ($this->columnExists($name)) {
            return $this;
        }

        if ($after) {
            $this->currentField = "ADD COLUMN `$name` $type AFTER `$after` ";
        } else {
            $this->currentField = "ADD COLUMN `$name` $type";
        }

        $this->fields[] = $this->currentField;
        return $this;
    }
}
