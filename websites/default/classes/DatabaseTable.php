<?php
class Databasetable {
    private $pdo;
    private $table;
    private $primaryKey;

    //takes 3 parameters (the database connection stored in the variable pdo), the table name, and the primary key
    public function __construct($pdo, $table, $primaryKey) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }
    
    //function for insertinf records to the databas 
    private function insert($record) {
        $keys = array_keys($record);
        $values = implode(', ', $keys);

        $valuesWithColon = implode(', :', $keys);
        $query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';
        $stmt = $this->pdo->prepare($query);
        
        $stmt->execute($record);
    }

    //functio for updatng recrds to the databasse
    private function update($record) {
        $query = 'UPDATE ' . $this->table . ' SET ';

        $parameters = [];
        foreach ($record as $key => $values) {
            $parameters[] = $key . ' = :' . $key;
        }

        $query .= implode(', ', $parameters);
        $query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';

        $record['primaryKey'] = $record[$this->primaryKey];

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($record);
    }

    //fnction for saving a record to the database
    public function save($record) {
        if (isset($record[$this->primaryKey]) && $record[$this->primaryKey] == "") {
            unset($record[$this->primaryKey]);
        }
        try {
            //here in the save function the insert function is being triggered 
            $this->insert($record);
        } 
        catch (Exception $e) {
            //here in the save function the update function is being triggered 
            $this->update($record);
        }
    }

    //function for selectng from a table in the database
    public function find($field, $value) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value';
        $parameters = ['value' => $value];

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);
        return $stmt->fetchAll();
    }

    //function for selectng all columns of a table in the databasse
    public function findAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
        $stmt->execute();
        return $stmt->fetchAll();
        
    }

    //function for counting records
    public function countRecords($field, $value) {
        $query = 'SELECT COUNT(*) FROM ' . $this->table . ' WHERE ' . $field . ' = :value';
        $parameters = ['value' => $value];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);
        return $stmt->fetch()[0]; 
    }

    //function foor delteting a recorrd from the database
    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id';
        $parameters = ['id' => $id];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);
    }

   
    //the begining of the AI assisted code
    //the Prompt used is: “Write a PHP function that filters database records based on an array of conditions, including more freedom for the text search fields and exact match for others.”
    //function for the search functionality for fincing records when multiple filters  are selected in the search functionality
    public function findFiltered($filters) {
        //selecting all columns in a table 
        $query = 'SELECT * FROM ' . $this->table;
        //initializing $parameters
        $parameters = [];
        
        //checking that $filters is not empty
        if (!empty($filters)) {
            //adding WHERE to the $query
            $query = $query . ' WHERE ';
            //initializing $conditions
            $conditions = [];
            
            foreach ($filters as $key => $value) {
                //checking if the column table is coursesTitle or coursesDes
                if ($key === 'coursesTitle' || $key === 'coursesDes') {
                    //if the column table is coursesTitle or coursesDes then allowing more flexible text search
                     $conditions[] = $key . ' LIKE :' . $key;
                     $parameters[$key] = '%' . $value . '%';
                } 
                //but if the column table is not coursesTitle or coursesDes then using the following for exact match
                else {
                     $conditions[] = $key . ' = :' . $key;
                     $parameters[$key] = $value;
                }
            }
            
            //checking that $conditions is not empty
            if (!empty($conditions)) {
                //adding all the conditions, stored in $conditions, using the AND, and storing the filtering query in $query
                $query = $query . implode(' AND ', $conditions);
            } else {
                //if filters were empty, then returnining all courses
                return $this->findAll();
            }
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);
        return $stmt->fetchAll();
    }
    //explaining the function in more details: it is a PHP database method that retrives records from a table and applies dynamic filterin based on an array of conditions, and it performs partial text searches using LIKE for certain fields and exact matches for the other fields
    //the end of the AI assisted code



    //the begining of the AI assisted code
    //the Prompt used is: "Write a PHP reusable database method that fetches records from a table with pagination support"
    //functio for selecting records from a tbale in the database, to be used for slecting and displaying no more than 10 courses per page for each subject arrea 
    public function searchPageLimit($field, $value, $limit, $offset) {
        //writing a sql query to select records from a tbale in the database, to be used for slecting and displaying no more than 10 courses per page for each subject arrea 
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value LIMIT ' . $limit . ' OFFSET ' . $offset;
        $parameters = ['value' => $value];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);
        return $stmt->fetchAll();
    }
    //explaining the function in more details: it is a reusable PHP database method that retrievs records from a database table based on  specified field and value. It supports pagnation by using LIMIT and OFFSET, allowing a specfic number of records to be returned startin from a given position
    //the end of the AI assisted code    
}