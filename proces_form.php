<?php
require_once('database');

// Traitement du formulaire soumis
if (isset($_POST['submit'])) {
    $image = $_FILES["image"]["name"];
    $titre = $_POST["titre"];
    $auteur = $_POST["auteur"];
    $date = $_POST["date"];
    $commentaire = $_POST["commentaire"];
    $description = $_POST["description"];

    print_r($_FILES['image']);
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>