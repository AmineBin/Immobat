<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Entity\Proprietaire;
use App\Entity\Ville;
use App\Entity\Fonctionnalite;
use App\Entity\ModeGestion;
use App\Repository\Repository;

class ProprietaireRepository extends Repository
{
    // fonction de connexion
    public function ajoutProprietaire(Proprietaire $proprioACreer)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("insert into proprietaire 
            values (0,:par_nom,:par_prenom,:par_email,:par_telephone,:par_id_gestion,:par_insee_ville,:par_rue)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_nom', $proprioACreer->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $proprioACreer->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_email', $proprioACreer->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':par_telephone', $proprioACreer->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':par_id_gestion', $proprioACreer->getLeModeDeGestion()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_insee_ville', $proprioACreer->getLaVille()->getInsee(), PDO::PARAM_INT);
            $req->bindValue(':par_rue', $proprioACreer->getRue(), PDO::PARAM_STR);
            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
    }
    public function getLesProprios()
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesProprios = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select proprietaire.id as id,
        proprietaire.nom, prenom, telephone, email, ville.nom as 'ville', proprietaire.rue,
        mode_gestion.libelle as 'libelle' from proprietaire
        join ville on ville.insee = insee_ville
        join mode_gestion on mode_gestion.id = id_gestion");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unproprio = new Proprietaire(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom,
                $enreg->email,
                $enreg->telephone,
                new ModeGestion(null, $enreg->libelle),
                new Ville(null, $enreg->ville, null),
                $enreg->rue
            );
            // on ajout l'instance dans la liste
            array_push($lesProprios, $unproprio);
        }
        return $lesProprios;
    }
    public function verificationProprioIdentique(Proprietaire $proprioAVerifier){ 
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select count(*) as nb from proprietaire
        where prenom = :par_prenom and proprietaire.nom = :par_nom and insee_ville = :par_insee_ville ");

        // On affecte une valeur aux paramètres déclarés dans la requête
        $req->bindValue(':par_prenom', $proprioAVerifier->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':par_nom', $proprioAVerifier->getNom(), PDO::PARAM_STR);
        $req->bindValue(':par_insee_ville', $proprioAVerifier->getLaVille()->getInsee(), PDO::PARAM_INT);
        // On demande l'exécution de la requête
        $ret = $req->execute();
        $resultat = $req->fetch();
        if ($resultat->nb > 0){

            $ret = true;
            return $ret;
        }
        else
        {
            $ret = false;
            return $ret;
        }
    }
    public function verifProprioIdentique(Proprietaire $proprioAVerifier){ 

        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select count(*) as nb from proprietaire
        where prenom = :par_prenom and proprietaire.nom = :par_nom and insee_ville = :par_insee_ville
        and id != :par_id_proprietaire");
        // On affecte une valeur aux paramètres déclarés dans la requête
        $req->bindValue(':par_prenom', $proprioAVerifier->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':par_nom', $proprioAVerifier->getNom(), PDO::PARAM_STR);
        $req->bindValue(':par_insee_ville', $proprioAVerifier->getLaVille()->getInsee(), PDO::PARAM_INT);
        $req->bindValue(':par_id_proprietaire', $proprioAVerifier->getId(), PDO::PARAM_INT);
        // On demande l'exécution de la requête
        $ret = $req->execute();
        $resultat = $req->fetch();
        if ($resultat->nb > 0){

            $ret = true;
            return $ret;
        }
        else
        {
            $ret = false;
            return $ret;
        }
    }
    public function getUnProprietaire($id)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select proprietaire.id as id,
        proprietaire.nom, prenom, telephone, email, ville.nom as 'ville', proprietaire.rue,
        ville.insee as 'insee', mode_gestion.libelle as 'libelle',
        mode_gestion.id as 'gestionid'from proprietaire
        join ville on ville.insee = insee_ville
        join mode_gestion on mode_gestion.id = id_gestion where proprietaire.id = :par_id");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $enreg = $req->fetch();
        if ($enreg == false) { // le propriétaire n'existe pas 
            return null;
        } else { // le propriétaire  existe 
            // on crée une instance
            $unproprio = new Proprietaire(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom,
                $enreg->email,
                $enreg->telephone,
                new ModeGestion($enreg->gestionid, $enreg->libelle),
                new Ville($enreg->insee, $enreg->ville, null),
                $enreg->rue
            );
            return $unproprio;
        }       
    }
    public function modifProprietaire(Proprietaire $proprioAModifier)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("update proprietaire
            set nom = :par_nom,
            prenom = :par_prenom,
            email = :par_email,
            telephone = :par_telephone,
            id_gestion = :par_id_gestion,  
            insee_ville = :par_insee_ville,
            rue = :par_rue
            where id = :par_id_proprio");

            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_nom', $proprioAModifier->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $proprioAModifier->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_email', $proprioAModifier->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':par_telephone', $proprioAModifier->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':par_id_gestion', $proprioAModifier->getLeModeDeGestion()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_insee_ville', $proprioAModifier->getLaVille()->getInsee(), PDO::PARAM_INT);
            $req->bindValue(':par_rue', $proprioAModifier->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_id_proprio', $proprioAModifier->getId(), PDO::PARAM_INT);

            // on demande l'exécution de la requête 

            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }

    public function supprimProprietaire(Proprietaire $proprioASupprimer)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("DELETE FROM `proprietaire`
             WHERE id = :par_id_proprio");

            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_proprio', $proprioASupprimer->getId(), PDO::PARAM_INT);

            // on demande l'exécution de la requête 

            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }

    public function existeContrat(Proprietaire $leProprio)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
            // on prépare la requête select count
            $req = $db->prepare("SELECT COUNT(*) as nb from contrat
            where contrat.id_appartement = (SELECT id from appartement
            where appartement.id_proprietaire = :par_id_proprio) and contrat.fin > CURDATE()");
            
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_proprio', $leProprio->getId(), PDO::PARAM_INT);

            // on demande l'exécution de la requête 

            $ret = $req->execute();
            $enreg = $req->fetch();

            if($enreg->nb > 0){
                return false;
            }
            else{
                return true;
            }
    }
}
