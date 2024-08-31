<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Entity\Garant;
use App\Repository\Repository;

class GarantRepository extends Repository
{
    public function getLesGarant(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesGarants = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select id, nom, prenom from garant");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unGarant = new Garant(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom
            );
            // on ajout l'instance dans la liste
            array_push($lesGarants, $unGarant);
        }
        return $lesGarants;
    }
    public function getUnGarant($id): ?Garant
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select id, nom, prenom from garant where id = :par_id");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $enreg = $req->fetch();
        if ($enreg == false) { // l'appartement n'existe pas 
            return null;
        } else { // l'appartement  existe 
            // on crée une instance
            $unGarant = new Garant(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom
            );
            return $unGarant;
        }
    }
}
