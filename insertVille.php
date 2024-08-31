<?php
try {
    $dsn = "mysql:host=" . "10.1.3.11" . ";port=" . "3306" . ";dbname=" . "immobat" . ";charset=" . "UTF8";
    $db = new PDO($dsn, "app_yurim56KLs", "JEub@e2023PgLf");
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    // Activation des erreurs PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOEXCEPTION $err) {
    die("BDAcc erreur de connexion à la base de données.<br>Erreur :" . $err->getMessage());
}
$nom_fichier = readline("Veuillez indiquer le nom du fichier à traiter : ");

// on vérifie que le fichier existe bien
if (file_exists($nom_fichier) == false) {
	echo ("Le fichier n'existe pas");
}
else {
    $pointeur_fichier = fopen($nom_fichier, 'r');

		if ($pointeur_fichier == false) {
			// l'ouverture du fichier s'est mal passée
			echo ("Problème d'ouverture du fichier");
		} 
		else {
            while (feof($pointeur_fichier)== false) {
				$tab_donnees_enreg = fgetcsv($pointeur_fichier, 39193, ";");
                try{
                    if ($tab_donnees_enreg[0] > 60000 && $tab_donnees_enreg[0] < 61000){
                        $req = $db->prepare("insert ville values (:par_insee, :par_code_postal, :par_nom)");
                        $req->bindValue(':par_insee', $tab_donnees_enreg[0], PDO::PARAM_STR);
                        $req->bindValue(':par_code_postal', $tab_donnees_enreg[2], PDO::PARAM_STR);
                        $req->bindValue(':par_nom', $tab_donnees_enreg[1], PDO::PARAM_STR);
                        $req->execute();
                    }
                }
				catch (PDOException $e){
                    print($e);
                }
			}
        }
	fclose($pointeur_fichier);
    }
?>