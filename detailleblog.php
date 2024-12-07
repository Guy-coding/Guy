<?php require_once "partials/head.php"; ?>
<?php require('./partials/sidebar.php'); ?>

<div class="wrapper d-flex flex-column min-vh-100">
    <?php require('./partials/header.php'); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Rechercher des mots clés...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="searchButton">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "axpxcvbr_legion";
    $password = "0*B0mBm:7*7BdNBmw*";
    $dbname = "axpxcvbr_legion_web";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les informations de l'article
        $article_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $requete = "SELECT * FROM article WHERE id = :id";
        $stmt = $conn->prepare($requete);
        $stmt->bindParam(':id', $article_id, PDO::PARAM_INT);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        // Récupérer les tags associés à l'article
        $tagQuery = "SELECT t.name as tg FROM tags t JOIN article_tag ati ON t.id = ati.tag_id WHERE ati.article_id = :id";
        $tagStmt = $conn->prepare($tagQuery);
        $tagStmt->bindParam(':id', $article_id, PDO::PARAM_INT);
        $tagStmt->execute();
        $tags = $tagStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fermer la connexion
        $conn = null;
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <img class="card-img-top" src="image/<?php echo htmlspecialchars($article['image'] ?? ''); ?>" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($article['titre'] ?? ''); ?></h5>
                        <div class="card-footer d-flex justify-content-between">
                            <p class="card-text">Auteur : <?php echo htmlspecialchars($article['auteur'] ?? ''); ?></p>
                            <p class="card-text">Date : <?php echo htmlspecialchars($article['date'] ?? ''); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($article['commentaire'] ?? ''); ?></p>
                        </div>
                        <p class="card-text"><?php echo $article['description'] ; ?></p>

                        <?php if (!empty($tags)) : ?>
                            <p class="card-text"><strong>Tags :</strong>
                                <?php foreach ($tags as $tag) : ?>
                                    <button class="btn btn-outline-secondary  "><?php echo  $tag['tg']; ?></button>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="mt-auto d-flex justify-content-end">
                        <form method="post" action="">
                            <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($article['id'] ?? 0); ?>">
                            <button type="submit" name="delete_article" class="btn btn-primary me-2">Supprimer</button>
                        </form>
                        <a href="modification_blog.php?id=<?php echo htmlspecialchars($article['id'] ?? 0); ?>" class="btn btn-primary me-2">Modifier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('./partials/footer.php'); ?>

    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            var searchInput = document.getElementById('searchInput').value;
            // Appeler la fonction de recherche des mots clés ici
            rechercherMotsCles(searchInput);
        });

        function rechercherMotsCles(mots_cles) {
            // Logique de recherche des mots clés à implémenter ici
            console.log('Recherche des mots clés : ' + mots_cles);
        }
    </script>

</body>
</html>
