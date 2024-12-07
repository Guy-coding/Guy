<?php require_once "partials/head.php"; ?>

  <?php require('./partials/sidebar.php'); ?>
    <div class="wrapper d-flex flex-column min-vh-100">
  <?php require('./partials/header.php'); ?>
      


      <!-- Qw3rt$Yz9  -->

      <?php
// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    // Traitement du téléchargement d'image
    $image = $_FILES['image']['name'];
    $destination = 'image/' . $image;
    $imagePath = pathinfo($destination, PATHINFO_EXTENSION);
    $validExtension = array("jpg", "png", "gif", "avif", "ico", "jpeg", "webm", "webp", "svg");
    $titre = $_POST['titre'];
    
    $date  = $_POST['date'];
    // Créez un nouvel objet DateTime à partir de l'entrée
    $dateTime = new DateTime($date);
    // Formatez la date en 'Y-m-d H:i:s'
    $date = $dateTime->format('Y-m-d H:i:s');
    
    $description = $_POST['description'];
    $secteur =  $_POST['secteur'];

    // Vérifier l'extension du fichier image
    if (!in_array(strtolower($imagePath), $validExtension)) {
        echo "L'extension du fichier image n'est pas valide.";
    } else {
        // Déplacer le fichier image dans le dossier "image"
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            echo "Le téléchargement de l'image a échoué.";
        } else {
            // Établir la connexion à la base de données
            $servername = "localhost";
            $username = "axpxcvbr_legion";
            $password = "0*B0mBm:7*7BdNBmw*";
            $dbname = "axpxcvbr_legion_web";


            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                 // Commencer une transaction
                 $conn->beginTransaction();

                // Préparer la requête d'insertion
                $requete = "INSERT INTO evenements (image, titre, secteur, date_deroulement, description) 
                           VALUES (:image, :titre, :secteur, :date, :description)";
                $stmt = $conn->prepare($requete);

                // Exécuter la requête
                $stmt->execute(array(
                    ':image' => $image,
                    ':titre' => $titre,
                    ':secteur' => $secteur,
                    ':date' => $date,
                    ':description' => $description                                                                     
                ));




              // Valider la transaction
              $conn->commit();
              
                echo "<script>alert('Événement enregistré'); window.location.href = 'evenements.php';</script>";
                

            } catch (PDOException $e) {
              // Annuler la transaction en cas d'erreur
              $conn->rollBack();

                // Afficher un message d'erreur
                echo "Erreur lors de l'enregistrement : " . $e->getMessage();
            }

            // Fermer la connexion à la base de données
            $conn = null;
        }
    }
}
?>

<div class="container my-5">
    <h1 class="mb-4" >Ajouter un Evenement</h1>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } elseif (isset($success)) { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>
<form method="POST" action="" enctype="multipart/form-data">

    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrez le titre de l'evenement" required>
    </div>

    <div class="form-group">
        <label for="date">Date et Heure de l'evenement</label>
        <input type="datetime-local" class="form-control" id="date" name="date"  required>
    </div>


        <div class="form-group mb-4 mt-4">
        <label for="image">Image</label>
        <input type="file" class="form-control-file" id="image" name="image" required>
    </div>
    <div class="form-group mb-4 mt-4" >
                <label for="secteur">Secteur</label>
                <input type="text" class="form-control" id="secteur" name="secteur" placeholder="Entrez les secteurs d'activites vises par l'evenement">
            </div>

        <textarea class="form-group" id="editor"  id="myEditor"  name="description" ></textarea>
    
    <button type="submit" name="submit" class="btn btn-primary" href="#" style="margin-top:10px;width:200px">Créer</button>
</form>

</div>

<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.2/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.2/"
        }
    }
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Paragraph,
        Bold,
        Italic,
        Font,
        Alignment,
        Autoformat,
        BlockQuote,
        CKFinder,
        CloudServices,
        EasyImage,
        Heading,
        Image,
        ImageCaption,
        ImageResize,
        ImageStyle,
        ImageToolbar,
        ImageUpload,
        Indent,
        Link,
        List,
        MediaEmbed,
        PasteFromOffice,
        Table,
        TableToolbar,
        Underline,
        CodeBlock,
        Highlight, 
        CKFinderUploadAdapter,
        SimpleUploadAdapter
    } from 'ckeditor5';

    ClassicEditor
        .create(document.querySelector('#editor'), {
            plugins: [
                Essentials, Paragraph, Bold, Italic, Font, Alignment, Autoformat, BlockQuote, CKFinder, CloudServices,
                EasyImage, Heading, Image, ImageCaption, ImageResize, ImageStyle, ImageToolbar, ImageUpload,
                Indent, Link, List, MediaEmbed, PasteFromOffice, Table, TableToolbar, Underline, CodeBlock, Highlight, CKFinderUploadAdapter, SimpleUploadAdapter
            ],
            toolbar: [
                'undo', 'redo', '|', 'heading', '|', 'bold', 'italic', 'underline', 'link', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                'alignment', 'outdent', 'indent', 'bulletedList', 'numberedList', '|',
                'blockQuote', 'insertTable', 'mediaEmbed', '|', 'codeBlock', 'highlight', 'imageUpload'
            ],
            image: {
                toolbar: [
                    'imageTextAlternative', 'imageStyle:full', 'imageStyle:side', '|',
                    'linkImage'
                ],
                resizeOptions: [
                    {
                        name: 'resizeImage:original',
                        label: 'Original',
                        value: null
                    },
                    {
                        name: 'resizeImage:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'resizeImage:75',
                        label: '75%',
                        value: '75'
                    }
                ]
            },
            simpleUpload: {
                // URL de l'endpoint pour l'upload des images
                uploadUrl: 'partials/img_upload.php',
                headers: {
                    // Ajouter des en-têtes personnalisés ici si nécessaire
                }
            }, 
            placeholder:"Contenu de l'article..",
            minHeight:"200px"

        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });
</script>

  <?php  require('./partials/footer.php'); ?>