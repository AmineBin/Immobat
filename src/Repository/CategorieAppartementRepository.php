<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Repository\Repository;
use App\Entity\CategorieAppartement;


class CategorieAppartementRepository extends Repository
{
    //méthode permettant d'obtenir tous les types d'appartements
    public function getLesTypes(): array
    {
        // on crèe le tableau qui contiendra la liste des types d'appartements
        $lesTypesAppart = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM type_appartement order by libelle");
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unTypeAppart = new CategorieAppartement(
                $enreg->id,
                $enreg->libelle,
            );
            // on ajout l'instance dans la liste
            array_push($lesTypesAppart, $unTypeAppart);
        }
        return $lesTypesAppart;
    }
    public function ajoutCategorieAppartement(CategorieAppartement $CategACreer)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("insert into type_appartement 
            values (0,:par_libelle)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_libelle', $CategACreer->getLibelle(), PDO::PARAM_STR);

            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
    }
}
