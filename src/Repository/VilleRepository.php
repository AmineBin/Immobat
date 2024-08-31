<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Repository\Repository;
use App\Entity\Ville;

class VilleRepository extends Repository
{
    public function getLesVilles(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesVilles = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select insee, code_postal, nom
                        from ville");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $uneVille = new Ville(
                $enreg->insee,
                $enreg->nom,
                $enreg->code_postal
            );
            // on ajout l'instance dans la liste
            array_push($lesVilles, $uneVille);
        }
        return $lesVilles;
    }
    public function getUneVille($insee): ?Ville
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select insee, nom, codePostal, 
                            from ville 
                             where insee = :par_insee");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_insee', $insee, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $enreg = $req->fetch();
        if ($enreg == false) { // la ville n'existe pas 
            return null;
        } else { // la ville  existe 
            // on crée une instance
            $uneVille = new Ville(
                $enreg->insee,
                $enreg->nom,
                $enreg->codePostal,
                
            );
            return $uneVille;
        }
    }
}