<?php
// Etablir la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legion_web";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    return $conn;
}
catch(PDOException $e){
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

?>

