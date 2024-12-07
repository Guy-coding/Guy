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
    $auteur = $_SESSION['admin_legionweb']['name'];
    $date  = date('Y-m-d');
    $description = $_POST['description'];
    $tags = explode(',', $_POST['tags']);

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
                $requete = "INSERT INTO article (image, titre, auteur, date, description) 
                           VALUES (:image, :titre, :auteur, :date, :description)";
                $stmt = $conn->prepare($requete);

                // Exécuter la requête
                $stmt->execute(array(
                    ':image' => $image,
                    ':titre' => $titre,
                    ':auteur' => $auteur,
                    ':date' => $date,
                    ':description' => $description                                                                     
                ));


                $articleId = $conn->lastInsertId();


                 // Insérer les tags et les associer à l'article
                 foreach ($tags as $tag) {
                  $tag = trim($tag);

                  // Vérifier si le tag existe déjà
                  $stmt = $conn->prepare("SELECT id FROM tags WHERE name = :name");
                  $stmt->execute([':name' => $tag]);
                  $tagId = $stmt->fetchColumn();

                  // Si le tag n'existe pas, l'insérer dans la table tags
                  if (!$tagId) {
                      $stmt = $conn->prepare("INSERT INTO tags (name) VALUES (:name)");
                      $stmt->execute([':name' => $tag]);
                      $tagId = $conn->lastInsertId();
                  }

                  // Associer le tag à l'article
                  $stmt = $conn->prepare("INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)");
                  $stmt->execute([':article_id' => $articleId, ':tag_id' => $tagId]);
              }

              // Valider la transaction
              $conn->commit();

                // Afficher un message de succès
                echo "<p>Bonjour Mme/Mr $auteur, votre article a été enregistré avec succès !</p>";

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
    <h1 class="mb-4" >Ajouter un article</h1>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } elseif (isset($success)) { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>
<form method="POST" action="" enctype="multipart/form-data">

    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrez le titre de l'article" required>
    </div>


        <div class="form-group mb-4 mt-4">
        <label for="image">Image</label>
        <input type="file" class="form-control-file" id="image" name="image" required>
    </div>
    <div class="form-group mb-4 mt-4" >
                <label for="tags">Tags</label>
                <input type="text" class="form-control" id="tags" name="tags" placeholder="Entrez les tags séparés par des virgules">
            </div>

        <textarea class="form-group" id="editor"  id="myEditor"  name="description" ></textarea>
    
    <button type="submit" name="submit" class="btn btn-primary" href="blog.php" style="margin-top:10px;width:200px">Créer</button>
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