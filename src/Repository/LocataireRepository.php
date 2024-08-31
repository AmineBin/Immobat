<?php
namespace App\Repository;

use App\Entity\Locataire;
use App\Entity\Ville;
use App\Entity\Impression;
use App\Entity\CategorieSocioprofessionnelle;
use PDO;
use PDOException;

class LocataireRepository extends Repository
{
    
    public function ajoutLocataire(Locataire $locaACreer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            $req = $db->prepare("insert into locataire
            values (0,:par_prenom,:par_nom,:par_email,:par_telephone,:par_insee_ville,:par_rue,:par_id_impression,:par_id_CategorieSocioprofessionnelle)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_nom', $locaACreer->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $locaACreer->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_email', $locaACreer->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':par_telephone', $locaACreer->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':par_insee_ville', $locaACreer->getVille()->getInsee(), PDO::PARAM_INT);
            $req->bindValue(':par_rue', $locaACreer->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_id_impression', $locaACreer->getImpression()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_CategorieSocioprofessionnelle', $locaACreer->getCategorieSocioprofessionnelle()->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
    }
    public function getLesLocataires(): array
    {
        // on crèe le tableau qui contiendra la liste des profils
        $LesLocataires = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("select locataire.id, prenom, locataire.nom as nom, email, insee, telephone, ville.nom as Vnom, rue, impression.libelle as libelle, categorie_Socioprofessionnelle.libelle as Clibelle from locataire join impression on impression.id = id_impression join categorie_Socioprofessionnelle on categorie_Socioprofessionnelle.id = id_categorie_socioprofessionnelle join Ville on Ville.insee = insee_ville");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unLocataire = new Locataire(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom,
                $enreg->email,
                $enreg->telephone,
                $enreg->rue,
                new Ville(
                    $enreg->insee,
                    $enreg->Vnom,
                    NULL
                ),
                new Impression(
                    $enreg->id,
                    $enreg->libelle
                ),
                new CategorieSocioprofessionnelle(
                    $enreg->id,
                    $enreg->Clibelle
                ),
            );
            // on ajout l'instance dans la liste
            array_push($LesLocataires, $unLocataire);
        }
        return $LesLocataires;
    }
    public function getUnLocataire($id): ?Locataire
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare(
            "select locataire.id, locataire.nom, prenom,email ,insee,telephone,ville.nom as Vnom, rue, impression.libelle as libelle,
            categorie_Socioprofessionnelle.libelle as Clibelle
                from locataire 
                join ville on ville.insee = insee_ville 
                join impression on impression.id = id_impression 
                join categorie_socioprofessionnelle on categorie_socioprofessionnelle.id = id_categorie_Socioprofessionnelle 
            where locataire.id = :par_id");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $enreg = $req->fetch();
        if ($enreg == false) { // le locataire n'existe pas 
            return null;
        } else { // le locataire  existe 
            // on crée une instance
            $unLocataire = new Locataire(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom,
                $enreg->email,
                $enreg->telephone,
                $enreg->rue,
                new Ville(
                    $enreg->insee,
                    $enreg->Vnom,
                    NULL
                ),
                new Impression(
                    $enreg->id,
                    $enreg->libelle
                ),
                new CategorieSocioprofessionnelle(
                    $enreg->id,
                    $enreg->Clibelle
                ),
            );
            return $unLocataire;
        }
    }
    public function modifLocataire(Locataire $locaAModifier): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("update locataire
            set  nom = ::par_nom,
            prenom = :par_prenom,
            email =:par_email
            telephone =:par_telephone
            insee_ville =:par_insee_ville
            par_rue =:par_rue
            id_impression =:par_id_impression
            id_categorie_socioprofessionnelle =:par_id_CategorieSocioprofessionnelle
            where id = :par_id_locataire");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_nom', $locaAModifier->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $locaAModifier->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_email', $locaAModifier->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':par_telephone', $locaAModifier->getTelephone(), PDO::PARAM_STR);
            $req->bindValue(':par_insee_ville', $locaAModifier->getVille()->getInsee(), PDO::PARAM_INT);
            $req->bindValue(':par_rue', $locaAModifier->getRue(), PDO::PARAM_STR);
            $req->bindValue(':par_id_impression', $locaAModifier->getImpression()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_CategorieSocioprofessionnelle', $locaAModifier->getCategorieSocioprofessionnelle()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_locataire', $locaAModifier->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
    public function supprLocataire(Locataire $locaASupprimer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête delete
            $req = $db->prepare("delete from locataire
            where id = :par_id_locataire");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_locataire', $locaASupprimer->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();
            

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
    public function condiSupprLocataire(Locataire $locaASupprimer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête delete
            $req = $db->prepare("select count(*) as nb from locataire
            join contrat on contrat.id_locataire = locataire.id
            where contrat.fin > CURDATE() and id_locataire = :par_id_locataire;
            ");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_locataire', $locaASupprimer->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();
            
            
            $enreg = $req->fetch();
            if ($enreg->nb == 0)
            {
                $ret = true;
            }
            else{
                $ret = false;
            }
            
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
}