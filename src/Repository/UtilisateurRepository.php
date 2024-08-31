<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Entity\Profil;
use App\Entity\Utilisateur;
use App\Entity\Fonctionnalite;
use App\Repository\Repository;

class UtilisateurRepository extends Repository
{
    // fonction de connexion
    public function connexionUtilisateur($pseudo, $motDePasse): ?Utilisateur
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $msg = "";
        if (trim($pseudo) == "") {
            $msg = $msg . "Le pseudo est obligatoire </br>";
        }
        if (trim($motDePasse) == "") {
            $msg = $msg . "Le mot de passe est obligatoire </br>";
        }
        if ($msg == "") {
            try {

                // on prépare la requête select
                $req = $db->prepare("SELECT id,nom, prenom,pseudo,mot_de_passe,id_profil 
                FROM utilisateur 
                WHERE pseudo = :par_pseudo");
                // on affecte une valeur au paramètre déclaré dans la requête 
                $req->bindValue(':par_pseudo', $pseudo, PDO::PARAM_STR);
                // on demande l'exécution de la requête 
                $req->execute();
                // on récupere la valeur retournée par la requête 
                $enreg = $req->fetch();
                if ($enreg == false) { // le pseudo n'existe pas 
                    return null;
                } else { // le pseudo existe 
                    // on crée une instance
                    $unUtilisateur = new Utilisateur(
                        $enreg->id,
                        $enreg->nom,
                        $enreg->prenom,
                        $enreg->pseudo,
                        $enreg->mot_de_passe,
                        new Profil($enreg->id_profil, null)
                    );
                }
            } catch (PDOException $e) {
                die("BDselConnex: erreur vérification connexion 
                                <br>Erreur :" . $e->getMessage());
            }
            return $unUtilisateur;
        } else {
            return null;
        }
    }
    public function fonctUtilisateur($profil): array
    {
        // on crèe le tableau qui contiendra la liste des fonctionnalités
        $lesFoncts = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("select f.libelle,theme, action
            from fonctionnalite f
            join profil_fonct pf on pf.id_fonct = f.id
            join profil p on pf.id_profil =  p.id 
            where p.id =:par_profil");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_profil', $profil, PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $req->execute();
            // on récupere la valeur retournée par la requête 
            $lesEnregs = $req->fetchAll();
            foreach ($lesEnregs  as $enreg) {
                // on crée une instance
                $uneFonct = new Fonctionnalite(
                    null,
                    $enreg->libelle,
                    $enreg->theme,
                    $enreg->action
                );
                // on ajout l'instance dans la liste
                array_push($lesFoncts, $uneFonct);
            }
        } catch (PDOException $e) {
            die("BDselprofil: erreur accès profil 
                            <br>Erreur :" . $e->getMessage());
        }
        return $lesFoncts;
    }
    public function ajoutUtilisateur(Utilisateur $utilACreer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            $req = $db->prepare("insert into utilisateur
            values (0,:par_nom,:par_prenom,:par_pseudo,:par_motDePasse,:par_id_profil)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_nom', $utilACreer->getNom(), PDO::PARAM_STR);
            $req->bindValue(':par_prenom', $utilACreer->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':par_pseudo', $utilACreer->getPseudo(), PDO::PARAM_STR);
            $req->bindValue(':par_motDePasse', $utilACreer->getMotDePasse(), PDO::PARAM_STR);
            $req->bindValue(':par_id_profil', $utilACreer->getProfil()->getId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
    }
    public function getLesUtilisateurs(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesUtilisateurs = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT u.id, nom, prenom, pseudo, p.libelle, mot_de_passe FROM utilisateur AS u JOIN profil AS p ON u.id = p.id;");
        // on demande l'exécution de la requête 
        $req->execute();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $unUtilisateur = new Utilisateur(
                $enreg->id,
                $enreg->nom,
                $enreg->prenom,
                $enreg->pseudo,
                $enreg->mot_de_passe,
                new Profil(null, $enreg->libelle)
            );
            // on ajout l'instance dans la liste
            array_push($lesUtilisateurs, $unUtilisateur);
        }
        return $lesUtilisateurs;
    }

    public function fonctTheme($profil): array
    {
        // on crèe le tableau qui contiendra la liste des fonctionnalités
        $lesTheme = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("SELECT DISTINCT(theme)
            from fonctionnalite AS f
            join profil_fonct AS pf on pf.id_fonct = f.id
            join profil AS p on pf.id_profil =  p.id 
            where p.id =:par_profil");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_profil', $profil, PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $req->execute();
            // on récupere la valeur retournée par la requête 
            $lesEnregs = $req->fetchAll();
            foreach ($lesEnregs  as $enreg) {
                // on crée une instance
                $uneTheme = new Fonctionnalite(
                    null,
                    null,
                    $enreg->theme,
                    null
                );
                // on ajout l'instance dans la liste
                array_push($lesTheme, $uneTheme);
            }
        } catch (PDOException $e) {
            die("BDselprofil: erreur accès profil 
                            <br>Erreur :" . $e->getMessage());
        }
        return $lesTheme;
    }
}
