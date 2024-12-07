<!DOCTYPE html>
<html lang="fr">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="name" content="LegionWeb | Adminstration">
    <meta name="description" content="LegionWeb-Adminstration,  Digital for business">
    <meta name="author" content="Serge Noah">
    <meta name="keyword" content="Digatalisation, Legion, Web, LegionWeb, Transformation Digitale, numerisation, Developpement, Software, admin, suite, business"> 

    <title>Legion Web | Administration</title>
    <link rel="shortcut icon" href="assets/favicon/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/favicon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon-180x180.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="css/style.css" rel="stylesheet">
    <script src="js/config.js"></script>
    <script src="js/color-modes.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .login-container {
            margin-top: 10%;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {

            background-color: rgba(221, 156, 24, 0.705);
            color: white;
            text-align: center;
            font-size: 1.5rem;
            padding: 1rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .text-orange {
            color: #fff6ee;
        }
    </style>
</head>
<body>

<?php
session_start();
// Établir la connexion à la base de données
ini_set("display_errors", E_ALL);
$servername = "localhost";
$username = "axpxcvbr_legion";
$password = "0*B0mBm:7*7BdNBmw*";
$dbname = "axpxcvbr_legion_web";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Échec de la connexion à la base de données : " . $e->getMessage());
}
if (isset($_SESSION['admin_legionweb']) && !empty($_SESSION['admin_legionweb']) && $_SESSION['admin_legionweb'] != null ) {
  header("Location: formblog.php");
  exit;
}
// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Vérifier si l'utilisateur existe

    $sql = "SELECT * FROM utilisateurs WHERE nom = :username";
    $sql = "SELECT * FROM utilisateurs WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Récupérer le mot de passe haché
        $storedPassword = $result["mot_de_passe"];

        // Vérifier le mot de passe
        if (md5($password) == $storedPassword) {
            // Connexion réussie, démarrer la session
            session_start();
            $_SESSION["admin_legionweb"] = [
                "id" => $result["id"],
                "username" => $result["username"],
                "name" => $result["nom"],
                "email" => $result["email"]
            ];

            // Rediriger vers la page d'administration
            echo ' <script> window.location.pathname = "admin/formblog.php"</script>';
            exit;
        } else {
            $error = "Le mot de passe est incorrect. " . md5($password);
        }
    } else {
        $error = "Le nom d'utilisateur n'existe pas.";
    }

    $stmt->closeCursor();
}
?>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-orange">
                    Bienvenue chez vous
                </div>
                <div class="card-body">
                    <p class="text-center">Veuillez vous identifier</p>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <div id="usernameError" class="text-danger"></div>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div id="passwordError" class="text-danger"></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                    </form>
                    <?php if (isset($error)) { ?>
                        <p class="text-danger text-center mt-3"><?php echo $error; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function validateForm() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const values = {
        username: username,
        password: password
    };

    const errors = validate(values);

    if (Object.keys(errors).length > 0) {
        displayErrors(errors);
        return false;
    }

    return true;
}

function validate(values) {
    let errors = {};

    if (values.username.trim() === "") {
        errors.username = "Le nom d'utilisateur est requis.";
    }

    if (values.password.trim() === "") {
        errors.password = "Le mot de passe est requis.";
    } else if (values.password.length < 6) {
        errors.password = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    return errors;
}

function displayErrors(errors) {
    document.getElementById("usernameError").textContent = errors.username || "";
    document.getElementById("passwordError").textContent = errors.password || "";
}
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
