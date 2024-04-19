<?php
    // phpinfo();
    // var_dump($_REQUEST);
    // var_dump($_SERVER);
//    var_dump($_GET);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    <title>List of users</title>
</head>
<body>
    <div class="row">
        <div class="col-8 col-offset-2">
            <h2>Veuillez remplir les informations</h2>
        </div>
    </div>
    <div class="row">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" name="firstname" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="adress" class="form-label">Adress</label>
                <input type="text" name="adress" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="birthdate"> Date de naissance</label>
                <input type="date" nam="birthdate" class="form-control">
            </div>
            <div class="col-md-6">
                <button type="submit" class="button"> Enregistrer</button>
            </div>
        </form>
    </div>

    <?php
    //Déclaration erreur
    // $nameErr = "";
    // if($_SERVER["REQUEST_METHOD"] == "POST"){
    //     if(empty($_POST['name'])){
    //         $nameErr = "Le nom est obligatoire";
    //     }else{
    //         $name = $_POST['name'];
    //         if(!preg_match("/^[a-za-Z]*$/",$name)){
    //             $nameErr = "Le nom doit contenir seulement des alphabets";
    //         }
    //     }
    //     $firstname = $_POST['firstname'];
    //     $adress = $_POST['adress'];
    //         if(file_exists('data.csv')){
    //             $fichier = fopen("data.csv", "a");
    //             fputcsv($fichier, [$name, $firstname,$adress]);
    //     }
    //     $fichier = fopen("data.csv", "a+");
    //     fputcsv($fichier, [$name, $firstname,$adress]);

    // }
    $nameErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation du nom
    if (empty($_POST['name'])) {
        $nameErr = "Le nom est obligatoire";
    } else {
        $name = $_POST['name'];
        if (!preg_match("/^[a-zA-Z\séèàêîôûëïüÿç-]*$/u", $name)) {
            $nameErr = "Le nom doit contenir seulement des alphabets";
        }
    }

    $firstname = $_POST['firstname'];
    $adress = $_POST['adress'];

    // Écriture dans le fichier CSV
    if ($nameErr === "") {
        if (!file_exists("data.csv")) {
            // Création du fichier CSV avec les en-têtes
            $fichier = fopen("data.csv", "a+");
            fputcsv($fichier, ["Nom", "Prénom", "Adresse"]);
            fclose($fichier);
        }

        // Ajout des nouvelles données
        if (($fichier = fopen("data.csv", "a+")) !== false) {
            fputcsv($fichier, [$name, $firstname, $adress]);
            fclose($fichier);
        } else {
            echo "Erreur lors de l'ouverture du fichier CSV";
        }
    }
}

// Lecture des données du fichier CSV et affichage dans un tableau HTML
echo "<table border='1'>";
echo "<tr><th>Nom</th><th>Prénom</th><th>Adresse</th></tr>";
if (($fichier = fopen("data.csv", "r")) !== false) {
    while (($data = fgetcsv($fichier, 1000, ",")) !== false) {
        echo "<tr>";
        foreach ($data as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    fclose($fichier);
} else {
    echo "Erreur lors de l'ouverture du fichier CSV";
}
echo "</table>";

    ?>
</body>
</html>
