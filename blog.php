<?php  require_once "partials/head.php"; ?>
  <?php require('./partials/sidebar.php'); ?>
    <div class="wrapper d-flex flex-column min-vh-100">
  <?php require('./partials/header.php'); ?>
      





      <div class="row justify-content-center" style="margin-bottom:100px">
            <div class="col-md-6">
              <form action="" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="s" id="searchInput" placeholder="Rechercher ...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="searchButton">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
              </form>
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

    // Récupérer les articles
    $requete = "SELECT * FROM article";
    $stmt = $conn->prepare($requete);
    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Traitement de la suppression
    if (isset($_POST['delete_article'])) {
        $id = $_POST['article_id'];
        $stmt = $conn->prepare("DELETE FROM article WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "<script> alert('Article de blog supprimé avec succès !'); window.location.href = 'formblog.php'</script>";
    }

    // Fermer la connexion
    $conn = null;
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

<div class="container">
  <div class="row">
    <?php foreach ($articles as $article) { ?>
    <div class="col-md-4 mb-4">
  <div class="card h-100">
    <img class="card-img-top" style="width: 100%; height=50vh; " src="./image/<?php echo $article['image']; ?>" alt="<?php echo $article['titre']?>">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title"><?php echo $article['titre']; ?></h5>
      <div class="card-footer d-flex justify-content-between">
            <p class="card-text">Auteur : <?php echo $article['auteur']; ?></p>
            <p class="card-text">Date : <?php echo $article['date']; ?></p>
            <p class="card-text"><?php echo $article['commentaire']; ?></p>
          </div>
      <p class="card-text"><?php echo substr($article['description'], 0, 300) . '...'; ?></p>
      <div class="mt-auto d-flex justify-content-end">
        <form method="post" action="">
          <input type="hidden" name="article_id" value="<?php echo $article['id']; ?>">
          <button type="submit" name="delete_article" class="btn btn-primary me-2">Supprimer</button>
        </form>
        <!-- <a class="btn btn-primary" href="modification_blog.php">Modifier</a> -->
        <a href="modification_blog.php?id=<?php echo $article['id']; ?>"" class="btn btn-primary me-2">
  Modifier
</a>
        <a class="btn btn-primary" href="detailleblog.php?id=<?php echo $article['id']; ?>">Détails</a>
      </div>
    </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
                                                

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php  require('./partials/footer.php'); ?>



  </body>
</html>