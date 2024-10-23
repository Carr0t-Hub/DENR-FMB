<?php

//Local Connection
$host = 'localhost';
$db = 'engpProject';
$username = 'root';
$password = '';

try {
    $mysqli = new PDO("mysql:host=$host;dbname=$db", $username, $password);

    $mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo $e->getMessage();
}

session_start();

function getENGP($mysqli)
{
    $sql = "SELECT * FROM engp WHERE category = 'Grand Total'";
    $temp = array();
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $temp[] = $row;
    }
    return $temp;
}