<?php
namespace App\Repository;

use App\Repository\Repository;
use App\Entity\CategorieSocioprofessionnelle;

class CategorieSocioprofessionnelleRepository extends Repository
{
    //méthode permettant d'obtenir tous les types d'appartements
    public function getLesCategorieSocioprofessionnelles(): array
    {
        // on crèe le tableau qui contiendra la liste des types d'appartements
        $lesCategorieSocioprofessionnelles = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM categorie_Socioprofessionnelle order by libelle");
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $uneCategorieSocioprofessionnelle = new CategorieSocioprofessionnelle(
                $enreg->id,
                $enreg->libelle,
            );
            // on ajout l'instance dans la liste
            array_push($lesCategorieSocioprofessionnelles, $uneCategorieSocioprofessionnelle);
        }
        return $lesCategorieSocioprofessionnelles;
    }

}