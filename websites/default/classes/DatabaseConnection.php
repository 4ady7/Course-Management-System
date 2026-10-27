<?php
//writing a function to connect to the database
function DatabaseConnection() {
    //creating a database connection, and storing it in the variable pdo
    $pdo = new PDO('mysql:host=mysql;dbname=CSY2089-AS1;charset=utf8', 'student', 'student');
    //returning the variable that has the database connection each time the function is called
    return $pdo;
}
?>