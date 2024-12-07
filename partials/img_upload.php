<?php
session_start();

// Vérification de l'accès
if (!isset($_SESSION['admin_legionweb']) || empty($_SESSION['admin_legionweb'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Accès refusé.']);
    exit;
}

// Chemin du dossier où les images seront sauvegardées
$uploadDir = __DIR__ . '/../image/';

// Vérification que le dossier existe, sinon le créer
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Vérification de l'existence du fichier téléchargé
if (!isset($_FILES['upload']) || $_FILES['upload']['error'] != 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Erreur lors du téléchargement de l\'image.']);
    exit;
}

// Récupération des informations du fichier
$fileTmpPath = $_FILES['upload']['tmp_name'];
$fileName = $_FILES['upload']['name'];
$fileSize = $_FILES['upload']['size'];
$fileType = $_FILES['upload']['type'];
$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

// Vérification du type de fichier (vous pouvez personnaliser la vérification)
$allowedExtensions = array("jpg", "png", "gif", "avif", "ico", "jpeg", "webm", "webp", "svg");
if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
    http_response_code(400);
    echo json_encode(['error' => 'Type de fichier non autorisé.']);
    exit;
}

// Génération d'un nom unique pour éviter les collisions
$newFileName = uniqid() . '.' . $fileExtension;

// Déplacement du fichier téléchargé vers le dossier des images
$destPath = $uploadDir . $newFileName;
if (move_uploaded_file($fileTmpPath, $destPath)) {
    // Renvoi de la réponse avec l'URL de l'image
    $imageUrl = '/admin/image/' . $newFileName;
    echo json_encode(['url' => $imageUrl]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la sauvegarde de l\'image.']);
}
?>
