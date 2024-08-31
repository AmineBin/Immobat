<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Entity\Contrat;
use App\Entity\Locataire;
use App\Entity\Garant;
use App\Entity\Appartement;
use App\Entity\CategorieAppartement;
use App\Repository\Repository;
use App\Repository\AppartementRepository;
use App\Repository\GarantRepository;
use App\Repository\LocataireRepository;
use Datetime;

class ContratRepository extends Repository
{
    public function existeContrat(Contrat $contrat)
    {
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("
            select count(*) as nb from contrat
            where debut = :par_debut and fin = :par_fin and id_locataire = :par_id_locataire
            ");
            $req->bindValue(':par_debut', $contrat->GetDebut()->format("Y-m-d"), PDO::PARAM_STR);
            $req->bindValue(':par_fin', $contrat->GetFin()->format("Y-m-d"), PDO::PARAM_STR);
            $req->bindValue(':par_id_locataire', $contrat->GetLocataire()->GetId(), PDO::PARAM_INT);
            $ret = $req->execute();
            $enreg = $req->fetch();
            if ($enreg->nb == 0)
            {
                $ret = false;
            }
            else
            {
                $ret = true;
            }
        } catch (PDOException $e) {
            $ret = true;
        }
        return $ret;
    }
    public function existeContratEnCour(Contrat $contrat)
    {
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("
            select count(*) as nb from contrat
            where fin > :par_debut and id_locataire = :par_id_locataire
            ");
            $req->bindValue(':par_debut', $contrat->GetDebut()->format("Y-m-d"), PDO::PARAM_STR);
            $req->bindValue(':par_id_locataire', $contrat->GetLocataire()->GetId(), PDO::PARAM_INT);
            $ret = $req->execute();
            $enreg = $req->fetch();
            if ($enreg->nb == 0)
            {
                $ret = false;
            }
            else
            {
                $ret = true;
            }
        } catch (PDOException $e) {
            $ret = true;
        }
        return $ret;
    }
    public function ajoutContrat(Contrat $contratACreer)
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête select
            $req = $db->prepare("insert into contrat 
            values (0,:par_debut,:par_fin,:par_montant_loyer_hc,
            :par_montant_charge, :par_montant_caution, :par_salaire_locataire,
            :par_id_locataire, :par_id_garant, :par_id_appartement)");
            // on affecte une valeur au paramètre déclaré dans la requête 
            // récupération de la date du jour 
            $req->bindValue(':par_debut', $contratACreer->GetDebut()->format("Y-m-d"), PDO::PARAM_STR);
            $req->bindValue(':par_fin', $contratACreer->GetFin()->format("Y-m-d"), PDO::PARAM_STR);
            $req->bindValue(':par_montant_loyer_hc', $contratACreer->GetMontantLoyerHC(), PDO::PARAM_INT);
            $req->bindValue(':par_montant_charge', $contratACreer->GetMontantCharge(), PDO::PARAM_INT);
            $req->bindValue(':par_montant_caution', $contratACreer->GetMontantCaution(), PDO::PARAM_INT);
            $req->bindValue(':par_salaire_locataire', $contratACreer->GetSalaireLocataire(), PDO::PARAM_INT);
            $req->bindValue(':par_id_locataire', $contratACreer->GetLocataire()->GetId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_garant', $contratACreer->GetGarant()->GetId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_appartement', $contratACreer->GetAppartement()->GetId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();
        } catch (PDOException $e) {
            $ret = false;
        }
        return $ret;
    }
    public function getLesContrats(): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesContrats = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare(
            "
            SELECT id, debut, fin, id_appartement, id_garant, id_locataire, montant_loyer_hc, montant_charge, montant_caution, salaire_locataire FROM contrat
            ");
        // on demande l'exécution de la requête 
        $req->execute();
        $unAppartRepo = new AppartementRepository();
        $unGarantRepo = new GarantRepository();
        $unLocataireRepo = new LocataireRepository();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $debut = new DateTime();
            $fin = new DateTime();
            if ($fin->createFromFormat('Y-m-d', $enreg->fin) == false){
                $fin = null;
            }
            else{
                $fin->createFromFormat('Y-m-d', $enreg->fin);
            }
            $unContrat = new Contrat(
                $enreg->id,
                $debut->createFromFormat('Y-m-d', $enreg->debut),
                $fin,
                $unAppartRepo->getUnAppartement($enreg->id_appartement),
                $unGarantRepo->getUnGarant($enreg->id_garant),                                                                                                                   
                $unLocataireRepo->getUnLocataire($enreg->id_locataire),
                $enreg->montant_loyer_hc,
                $enreg->montant_charge,
                $enreg->montant_caution,
                $enreg->salaire_locataire,
            );
            // on ajout l'instance dans la liste
            array_push($lesContrats, $unContrat);
        }
        return $lesContrats;
    }
    public function getLesContratsUnLocataire(Locataire $leLocataire): array
    {
        // on crèe le tableau qui contiendra la liste des appartements
        $lesContrats = array();
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare(
            "
            SELECT id, debut, fin, id_appartement, id_garant, id_locataire, montant_loyer_hc, montant_charge, montant_caution, salaire_locataire FROM contrat where id_locataire = :par_id_locataire
            ");
        // on demande l'exécution de la requête 
        $req->bindValue(':par_id_locataire', $leLocataire->getId(), PDO::PARAM_INT);
        $req->execute();
        $unAppartRepo = new AppartementRepository();
        $unGarantRepo = new GarantRepository();
        $unLocataireRepo = new LocataireRepository();
        $lesEnregs = $req->fetchAll();
        foreach ($lesEnregs  as $enreg) {
            // on crée une instance
            $debut = new DateTime();
            $fin = new DateTime();
            $unContrat = new Contrat(
                $enreg->id,
                $debut->createFromFormat('Y-m-d', $enreg->debut),
                $fin->createFromFormat('Y-m-d', $enreg->fin),
                $unAppartRepo->getUnAppartement($enreg->id_appartement),
                $unGarantRepo->getUnGarant($enreg->id_garant),                                                                                                                   
                $unLocataireRepo->getUnLocataire($enreg->id_locataire),
                $enreg->montant_loyer_hc,
                $enreg->montant_charge,
                $enreg->montant_caution,
                $enreg->salaire_locataire,
            );
            // on ajout l'instance dans la liste
            array_push($lesContrats, $unContrat);
        }
        return $lesContrats;
    }
    public function getUnContrat($id): ?Contrat
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        $req = $db->prepare(
            "select id, debut, fin, montant_loyer_hc,
            montant_charge, montant_caution, salaire_locataire,
            id_locataire, id_garant, id_appartement
            from contrat
            where id = :par_id");
        // on affecte une valeur au paramètre déclaré dans la requête 
        $req->bindValue(':par_id', $id, PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $req->execute();
        $unAppartRepo = new AppartementRepository();
        $unGarantRepo = new GarantRepository();
        $unLocataireRepo = new LocataireRepository();
        $enreg = $req->fetch();
        $debut = new DateTime();
        $fin = new DateTime();
        if ($fin->createFromFormat('Y-m-d', $enreg->fin) == false){
            $fin = null;
        }
        else{
            $fin->createFromFormat('Y-m-d', $enreg->fin);
        }
        if ($enreg == false) { // l'appartement n'existe pas 
            return null;
        } else { // l'appartement  existe 
            // on crée une instance
            $unContrat = new Contrat(
                $enreg->id,
                $debut->createFromFormat('Y-m-d', $enreg->debut),
                $fin,
                $unAppartRepo->getUnAppartement($enreg->id_appartement),
                $unGarantRepo->getUnGarant($enreg->id_garant),                                                                                                                   
                $unLocataireRepo->getUnLocataire($enreg->id_locataire),
                $enreg->montant_loyer_hc,
                $enreg->montant_charge,
                $enreg->montant_caution,
                $enreg->salaire_locataire
            );
            return $unContrat;
        }
    }
    public function modifContrat(Contrat $ContratAModifier): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare("update Contrat set
            debut = :par_debut,
            fin = :par_fin,
            montant_loyer_hc = :par_montant_loyer_hc,
            montant_charge = :par_montant_charge, 
            montant_caution = :par_montant_caution, 
            salaire_locataire = :par_salaire_locataire,
            id_locataire = :par_id_locataire, 
            id_garant = :par_id_garant, 
            id_appartement = :par_id_appartement
            where id = :par_id_contrat");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_debut', $ContratAModifier->GetDebut()->format("Y-m-d"), PDO::PARAM_STR);
            $req->bindValue(':par_fin', $ContratAModifier->GetFin()->format("Y-m-d"), PDO::PARAM_STR);
            $req->bindValue(':par_montant_loyer_hc', $ContratAModifier->GetMontantLoyerHC(), PDO::PARAM_INT);
            $req->bindValue(':par_montant_charge', $ContratAModifier->GetMontantCharge(), PDO::PARAM_INT);
            $req->bindValue(':par_montant_caution', $ContratAModifier->GetMontantCaution(), PDO::PARAM_INT);
            $req->bindValue(':par_salaire_locataire', $ContratAModifier->GetSalaireLocataire(), PDO::PARAM_INT);
            $req->bindValue(':par_id_locataire', $ContratAModifier->GetLocataire()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_garant', $ContratAModifier->GetGarant()->getId(), PDO::PARAM_INT); 
            $req->bindValue(':par_id_appartement', $ContratAModifier->GetAppartement()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_id_contrat', $ContratAModifier->GetId(), PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }public function supprContrat(int $contratASupprimer): bool
    {
        // on récupère l'objet qui permet de travailler avec la base de données
        $db = $this->dbConnect();
        try {
            // on prépare la requête update
            $req = $db->prepare(
            "delete from contrat 
            where id = :par_id_contrat");
            // on affecte une valeur au paramètre déclaré dans la requête 
            $req->bindValue(':par_id_contrat', $contratASupprimer, PDO::PARAM_INT);
            // on demande l'exécution de la requête 
            $ret = $req->execute();

            $ret = true;
        } catch (PDOException $e) {
            $ret = false;
        }

        return $ret;
    }
}
