<?php
$servername = "localhost";
$username = "axpxcvbr_legion";
$password = "0*B0mBm:7*7BdNBmw*";
$dbname = "axpxcvbr_legion_web";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $sql = "DELETE FROM contact_form WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        echo "Enregistrement supprimé avec succès.";
    }
} catch (PDOException $e) {
    echo "Erreur de suppression de l'enregistrement: " . $e->getMessage();
}

$conn = null; // Fermer la connexion
?>