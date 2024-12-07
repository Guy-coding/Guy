<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once "partials/head.php";
require_once "partials/sidebar.php";
require_once "partials/header.php";

// Database connection
$servername = "localhost";
$username = "axpxcvbr_legion";
$password = "0*B0mBm:7*7BdNBmw*";
$dbname = "axpxcvbr_legion_web";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Protect against SQL injection
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch article data
$sql = "SELECT * FROM evenements WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$article = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch existing tags
$sql = "SELECT GROUP_CONCAT(t.name SEPARATOR ', ') as tags FROM article_tag 
        JOIN tags t ON t.id = article_tag.tag_id WHERE article_tag.article_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$tags = $stmt->fetch(PDO::FETCH_ASSOC)['tags'];

// Handle form submission
if (isset($_POST['submit'])) {
    $titre = $_POST['titre'];
    $secteur = $_POST['secteur'];

    $date  = $_POST['date'];
    // Créez un nouvel objet DateTime à partir de l'entrée
    $dateTime = new DateTime($date);
    // Formatez la date en 'Y-m-d H:i:s'
    $date = $dateTime->format('Y-m-d H:i:s');

    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $destination = '';

    // Handle image upload
    if ($image) {
        $destination = 'image/' . $image;
        $imagePath = pathinfo($destination, PATHINFO_EXTENSION);
        $validExtensions = array("jpg", "png", "gif", "avif", "ico", "jpeg", "webm", "webp", "svg");

        if (!in_array(strtolower($imagePath), $validExtensions)) {
            echo "L'extension du fichier image n'est pas valide.";
        } else {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                echo "Le téléchargement de l'image a échoué.";
            }
        }
    } else {
        // Keep the old image if no new image is uploaded
        $destination = $article['image'];
    }

    // Update article
    $sql = "UPDATE evenements SET titre = :titre, description = :description, image = :image ,date_deroulement = :date_deroulement, secteur = :secteur WHERE id = $id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':date_deroulement', $date);
    $stmt->bindParam(':secteur', $secteur);
    $stmt->execute();
    echo "<script>alert('Événement Modifié'); window.location.href = 'detailleevenements.php?id=$id';</script>";

    // Handle tags
    //$tagsArray = array_map('trim', explode(',', $tagsInput));
    //$tagsArray = array_unique($tagsArray);

    // Remove old tags
    //$sql = "DELETE FROM article_tag WHERE article_id = :id";
    //$stmt = $conn->prepare($sql);
    //$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //$stmt->execute();

    // Insert new tags
    //$sqlTag = "INSERT INTO tags (name) VALUES (:tag_name) ON DUPLICATE KEY UPDATE name = name";
    //$tagStmt = $conn->prepare($sqlTag);
    
    /*foreach ($tagsArray as $tag) {
        // Insert tag into the tags table
        $tagStmt->bindParam(':tag_name', $tag);
        $tagStmt->execute();

        // Get tag ID
        $tagID = $conn->lastInsertId();
        if ($tagID == 0) {
            // If lastInsertId() returns 0, it means the tag already exists, so fetch its ID
            $stmt = $conn->prepare("SELECT id FROM tags WHERE name = :tag_name");
            $stmt->bindParam(':tag_name', $tag);
            $stmt->execute();
            $tagID = $stmt->fetchColumn();
        }

        // Link tag to the article
        $sqlMap = "INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)";
        $stmtMap = $conn->prepare($sqlMap);
        $stmtMap->bindParam(':article_id', $id, PDO::PARAM_INT);
        $stmtMap->bindParam(':tag_id', $tagID, PDO::PARAM_INT);
        $stmtMap->execute();
    }*/

    
}

?>

<div class="container my-5" style="margin-left: 17%;   @media (min-width: 200px) and (max-width: 991px): {margin-left:2%;color: red;}">
<div class="container my-5">
    <h1 class="mb-4">Modifier l'article</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
        </div>

        <div class="form-group">
            <label for="secteur">Secteur</label>
            <input type="text" class="form-control" id="secteur" name="secteur" value="<?php echo htmlspecialchars($article['secteur']); ?>" required>
        </div>

        <div class="form-group mb-4 mt-4">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <p>Image actuelle : <img src="image/<?php echo htmlspecialchars($article['image']) ?? ''; ?>" alt="Article Image" width="100"></p>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="datetime-local" class="form-control" id="date" name="date" value="<?php echo $article['date_deroulement']; ?>">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="editor" name="description"><?php echo htmlspecialchars($article['description']); ?></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary" style="margin-top:10px;width:200px">Mettre à jour</button>
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
                uploadUrl: 'partials/img_upload.php',
                headers: {
                    // Add custom headers if needed
                }
            }, 
            placeholder:"Contenu de l'article...",
            minHeight:"200px"
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });
</script>

<?php require('./partials/footer.php'); ?>
