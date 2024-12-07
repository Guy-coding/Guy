<?php
require_once('database');

// Vérifier si la requête POST est envoyée
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $image = mysqli_real_escape_string($conn, $_FILES["image"]["name"]);
    $titre = mysqli_real_escape_string($conn, $_POST["titre"]);
    $auteur = mysqli_real_escape_string($conn, $_POST["auteur"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $commentaire = mysqli_real_escape_string($conn, $_POST["commentaire"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);


    // Définir le répertoire de destination pour l'image
    $content_dir = 'image/';
    $tmp_file = $_FILES['image']['tmp_name'];
    $destination_file = $content_dir . basename($_FILES['image']['name']);

    // Vérifier s'il y a eu une erreur lors du téléchargement de l'image
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(500);
        echo "Une erreur est survenue lors du téléchargement de l'image : " . $_FILES['image']['error'];
        exit;
    }
}

    // Vérifier le type de fichier de l'image
    $type_file = $_FILES['image']['type'];
    if (!strstr($type_file, 'jpeg') && !strstr($type_file, 'png')) {
        http_response_code(400);
        echo "Type de fichier non autorisé.";
        exit;
    }

    // Déplacer l'image vers le répertoire de destination
    if (move_uploaded_file($tmp_file, $destination_file)) {
        // Insérer les données dans la base de données
        $sql = "INSERT INTO table_blog (image, titre, auteur, date, commentaire, description)
               VALUES ('$destination_file', '$titre', '$auteur', '$date', '$commentaire', '$description')";
        if ($conn->query($sql) === TRUE) {
            http_response_code(201);
            echo "Enregistrement ajouté avec succès !";
        } else {
            http_response_code(500);
            echo "Erreur lors de l'insertion dans la base de données : " . $conn->error;
        }
    } else {
        http_response_code(500);
        echo "Une erreur est survenue lors du téléchargement de l'image.";
    }
else {
    http_response_code(405);
    echo "Méthode non autorisée.";
}



$conn->close();
?>