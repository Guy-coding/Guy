<?php
// Etablir la connexion à la base de données
$servername = "localhost";
$username = "axpxcvbr_legion";
$password = "0*B0mBm:7*7BdNBmw*";
$dbname = "axpxcvbr_legion_web";



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

