<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Entity\Appartement;
use App\Repository\Repository;
use App\Entity\CategorieAppartement;
use App\Entity\Ville;
use App\Entity\Proprietaire;

class AppartementRepository extends Repository
{

    public function ajoutAppartement(Appartement $appartACreer)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("insert into Appartement 
            values (0,:par_rue,:par_batiment,:par_etage,:par_superficie,:par_orientation,:par_nbPiece,:par_id_type_appart,:par_id_proprietaire,:par_insee_ville)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_rue', $appartACreer->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_batiment', $appartACreer->getBatiment(), PDO::PARAM_STR);
            $req->bindValue(':par_etage', $appartACreer->getEtage(), PDO::PARAM_STR);
            $req->bindValue(':par_superficie', $appartACreer->getSuperficie(), PDO::PARAM_STR);
            $req->bindValue(':par_orientation', $appartACreer->getOrientation(), PDO::PARAM_STR);
            $req->bindValue(':par_nbPiece', $appartACreer->getNbPiece(), PDO::PARAM_STR);
            $req->bindValue(':par_id_type_appart', $appartACreer->getCategorieAppartement()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_proprietaire', $appartACreer->getProprietaire()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_insee_ville', $appartACreer->getVille()->getInsee(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
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
    public function modifAppartement(Appartement $appartAModifier): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("update appartement
            set rue = :par_rue,
                batiment = :par_batiment,
                etage = :par_etage, 
                superficie = :par_superficie,
                orientation = :par_orientation, 
                nb_piece = :par_nbPiece,  -- Correction : Suppression de l'espace en trop
                id_type_appartement = :par_id_type_appart,
                id_proprietaire = :par_id_proprietaire,
                insee_ville = :par_insee_ville
            where id = :par_id_appart");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_rue', $appartAModifier->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_batiment', $appartAModifier->getBatiment(), PDO::PARAM_STR);
            $req->bindValue(':par_etage', $appartAModifier->getEtage(), PDO::PARAM_STR);
            $req->bindValue(':par_superficie', $appartAModifier->getSuperficie(), PDO::PARAM_STR);
            $req->bindValue(':par_orientation', $appartAModifier->getOrientation(), PDO::PARAM_STR);
            $req->bindValue(':par_nbPiece', $appartAModifier->getNbPiece(), PDO::PARAM_STR);
            $req->bindValue(':par_id_type_appart', $appartAModifier->getCategorieAppartement()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_proprietaire', $appartAModifier->getProprietaire()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_insee_ville', $appartAModifier->getVille()->getInsee(), PDO::PARAM_INT);
            $req->bindValue(':par_id_type_appart', $appartAModifier->getCategorieAppartement()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_appart', $appartAModifier->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
    public function supprAppartement(Appartement $appartASupprimer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare(
            "delete from appartement 
            where id = :par_id_appart");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_appart', $appartASupprimer->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
    }
    //vérifie s'il il y a un contrat sur l'appartement
    public function condiSupprAppartement(Appartement $appartAVerifier): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare(
            "select count(*) from contrat where id_appartement = 0");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_appartement', $appartAVerifier->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
    public function getLesApparts(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesApparts = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select appartement.id as id, 
                        type_appartement.libelle, appartement.rue, batiment, etage, superficie, orientation, nb_piece, 
                        id_type_appartement, id_proprietaire, appartement.insee_ville, proprietaire.nom as pnom, ville.nom
                        from appartement
                join type_appartement on type_appartement.id = id_type_appartement
                join proprietaire on proprietaire.id = id_proprietaire
                join ville on ville.insee = appartement.insee_ville");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unAppart = new Appartement(
                $enreg->id,
                $enreg->rue,
                $enreg->batiment,
                $enreg->etage,
                $enreg->superficie,
                $enreg->orientation,
                $enreg->nb_piece,
                new CategorieAppartement(null, $enreg->libelle),
                new Proprietaire($enreg->id_proprietaire, $enreg->pnom, null, null, null, null, null, null),
                new Ville($enreg->insee_ville, $enreg->nom)
                
            );
            // on ajout l'instance dans la liste
            array_push($lesApparts, $unAppart);
        }
        return $lesApparts;
    }
    public function getUnAppartement($id): ?Appartement
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select appartement.rue, libelle, batiment, etage, appartement.id,superficie, orientation, nb_piece, id_type_appartement, id_proprietaire, proprietaire.nom as pnom, appartement.insee_ville, ville.nom from appartement 
        join type_appartement on type_appartement.id = id_type_appartement 
        join proprietaire on proprietaire.id = id_proprietaire
        join ville on ville.insee = appartement.insee_ville
        where appartement.id = :par_id;");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $enreg = $req->fetch();
        if ($enreg == false) { // l'appartement n'existe pas 
            return null;
        } else { // l'appartement  existe 
            // on crée une instance
            $unProprioRepo = new ProprietaireRepository();
            $unAppart = new Appartement(
                $enreg->id,
                $enreg->rue,
                $enreg->batiment,
                $enreg->etage,
                $enreg->superficie,
                $enreg->orientation,
                $enreg->nb_piece,
                new CategorieAppartement($enreg->id_type_appartement,$enreg->libelle,),
                $unProprioRepo->getUnProprietaire($enreg->id_proprietaire),
                new Ville($enreg->insee_ville, $enreg->nom)
            );
            return $unAppart;
        }
    }

    public function getLesAppartsLibres(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesAppartLibres = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select appartement.id as id, 
                        type_appartement.libelle, prenom, appartement.rue, batiment, etage, superficie, 
                        orientation, nb_piece, id_type_appartement, proprietaire.nom, ville.nom, 
                        id_proprietaire, appartement.insee_ville
                        from appartement
                join type_appartement on type_appartement.id = id_type_appartement
                join proprietaire on proprietaire.id = id_proprietaire
                join ville on ville.insee = appartement.insee_ville
                where appartement.id not in (select id_appartement from contrat)");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unAppart = new Appartement(
                $enreg->id,
                $enreg->rue,
                $enreg->batiment,
                $enreg->etage,
                $enreg->superficie,
                $enreg->orientation,
                $enreg->nb_piece,
                new CategorieAppartement(null, $enreg->libelle),
                new Proprietaire($enreg->id_proprietaire, $enreg->nom, $enreg->prenom, null, null, null, null, null, null),
                new Ville($enreg->insee_ville, $enreg->nom, null,),
                
            );
            // on ajout l'instance dans la liste
            array_push($lesAppartLibres, $unAppart);
        }
        return $lesAppartLibres;
    }
    public function filtreProprio(Appartement $proprioAFiltrer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare(
            "select count(*) from proprietaire where id = :par_id_proprio");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_proprio', $proprioAFiltrer->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
    public function filtreCategAppart(Appartement $categAppartAFiltrer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare(
            "select count(*) from type_appartement where id = :par_id_categ");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_categ', $categAppartAFiltrer->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
}
