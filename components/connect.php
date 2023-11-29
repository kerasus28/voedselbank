<?php

$user="user";
$pass="12345";
try {
    $conn = new PDO('mysql:host=localhost;dbname=voedselbank;port=3306', $user, $pass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>