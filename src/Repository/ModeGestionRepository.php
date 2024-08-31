<?php
namespace App\Repository;

use App\Repository\Repository;
use App\Entity\ModeGestion;


class ModeGestionRepository extends Repository
{
    //méthode permettant d'obtenir tous les modes de gestions
    public function getModeGestion(): array
    {
        // on crèe le tableau qui contiendra la liste des mode de gestion
        $lesModes = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM mode_gestion order by libelle");
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unMode = new ModeGestion(
                $enreg->id,
                $enreg->libelle,
            );
            // on ajout l'instance dans la liste
            array_push($lesModes, $unMode);
        }
        return $lesModes;
    }
}