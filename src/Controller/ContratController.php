<?php
namespace App\Controller;

use DateTime;
use App\Controller\Controller;
use App\Entity\Contrat;
use App\Repository\GarantRepository;
use App\Repository\ContratRepository;
use App\Repository\LocataireRepository;
use App\Repository\AppartementRepository;

class ContratController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function ajoutForm(): void
    {
        // il faut demander au modèle la liste des appartements pour alimenter la liste déroulante
        $AppartementRepository = new AppartementRepository();
        $lesAppartements = $AppartementRepository->getLesApparts();
        // il faut demander au modèle la liste des locataires pour alimenter la liste déroulante
        $unLocataireRepository = new LocataireRepository();
        $LesLocataires = $unLocataireRepository->getLesLocataires();
        // il faut demander au modèle la liste des garants pour alimenter la liste déroulante
        $unGarantRepository = new GarantRepository();
        $LesGarants = $unGarantRepository->getLesGarant();

        // on appelle la vue pour afficher le formulaire d'ajout d'un appartement
        $this->render(ROOT . "/templates/Contrat/ajout", array("title" => "Ajout d'un contrat", "lesApparts" => $lesAppartements, "LesLocataires" => $LesLocataires, "LesGarants" => $LesGarants));
    }
    public function ajoutTrait()
    {
        // on crée une instance de la classe Contrat à partir des données saisies sur le formulaire
        $AppartementRepository = new AppartementRepository();
        $unGarantRepository = new GarantRepository();
        $unLocataireRepository = new LocataireRepository();
        $locataire = $unLocataireRepository->getUnLocataire($_POST["lstLocataire"]);
        $contrat = new Contrat(
            0,
            new DateTime($_POST["debut"]),
            new DateTime($_POST["fin"]),
            $AppartementRepository->getUnAppartement($_POST["lstAppart"]),
            $unGarantRepository->getUnGarant($_POST["lstGarant"]),
            $locataire,
            $_POST["montantLoyer"],
            $_POST["montantCharge"],
            $_POST["montantCaution"],
            $_POST["salaire"]
        );
        // on crée une instance de AppartementRepository
        $unContratRepository = new ContratRepository();
        $AppartementRepository = new AppartementRepository();
        $lesAppartements = $AppartementRepository->getLesApparts();
        $unLocataireRepository = new LocataireRepository();
        $LesLocataires = $unLocataireRepository->getLesLocataires();
        $unGarantRepository = new GarantRepository();
        $LesGarants = $unGarantRepository->getLesGarant();

        // on appelle la méthode qui permet d'ajouter l'appartement
        // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
        // ret contient true si l'ajout s'est bien passé
        if ($unContratRepository->existeContrat($contrat) == false)
        {
            if ($unContratRepository->existeContratEnCour($contrat) == false)
            {
                $ret = $unContratRepository->ajoutContrat($contrat);

                // Réaffichage du formulaire (la vue Appartement/ajout)
                // ----------------------------------------------------
                // pour le formulaire, on récupère les types d'appartement
                // il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
                // dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
                if ($ret == false) {
                    // affichage d'un message d'erreur : l'appartement n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
                    $msg = "<p class='text-danger'>ERREUR : votre contrat n'a pas été enregistré</p>";
                    $this->render(ROOT . "/templates/Contrat/ajout", array(
                        "title" => "Ajout d'un contrat",
                        "msg" => $msg,
                        "lesApparts" => $lesAppartements,
                        "LesLocataires" => $LesLocataires,
                        "LesGarants" => $LesGarants,
                        "" => $contrat));
                } else {
                    // pas de  : l'appartement n'a pas été ajouté
                    $msg = "<p class='text-success'>Votre contrat a été enregistré</p>";
                    $this->render(ROOT . "/templates/Contrat/ajout", array("title" => "Ajout d'un contrat", "msg" => $msg, "lesApparts" => $lesAppartements, "LesLocataires" => $LesLocataires, "LesGarants" => $LesGarants));
                }
            }
            else
            {
                $msg = "<p class='text-danger'>Votre contrat n'a pas été enregistré, un contrat est déjà en cours sur cette période pour ce locataire</p>";
                $this->render(ROOT . "/templates/Contrat/ajout", array("title" => "Ajout d'un contrat", "msg" => $msg, "lesApparts" => $lesAppartements, "LesLocataires" => $LesLocataires, "LesGarants" => $LesGarants));
            }
        }
        else {
            // pas de  : l'appartement n'a pas été ajouté
            $msg = "<p class='text-danger'>Votre contrat n'a pas été enregistré, un contrat avec les mêmes dates existe déjà pour ce locataire</p>";
            $this->render(ROOT . "/templates/Contrat/ajout", array("title" => "Ajout d'un contrat", "msg" => $msg, "lesApparts" => $lesAppartements, "LesLocataires" => $LesLocataires, "LesGarants" => $LesGarants));
        }
    }
    public function liste(): void
    {
        $unContratRepository = new ContratRepository();
        $lesContrats = $unContratRepository->getLesContrats();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Contrat/consultListe", array("title" => "Liste des contrats", "lesContrats" => $lesContrats));
    }
    public function modifListe(): void
    {
        // on crée une instance de AppartementRepository
        $unContratRepository = new ContratRepository();

        // on demande au modèle la liste des appartements
        $lesContrats = $unContratRepository->getLesContrats();

        $this->render(ROOT . "/templates/Contrat/modifListe", array("title" => "Liste des appartements", "lesContrats" => $lesContrats));
    }
    public function modifForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idContrat =  $_POST["lstContrat"];

        // on crée une instance de AppartementRepository
        $unContratRepository = new ContratRepository();

        // on demande au modèle l'appartement à modifier 
        $lContrat = $unContratRepository->getUnContrat($idContrat);

        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
        // on crée une instance de AppartementRepository
        
        // il faut demander au modèle la liste des appartements pour alimenter la liste déroulante
        $AppartementRepository = new AppartementRepository();
        $lesAppartements = $AppartementRepository->getLesApparts();
        // il faut demander au modèle la liste des locataires pour alimenter la liste déroulante
        $unLocataireRepository = new LocataireRepository();
        $LesLocataires = $unLocataireRepository->getLesLocataires();
        // il faut demander au modèle la liste des garants pour alimenter la liste déroulante
        $unGarantRepository = new GarantRepository();
        $LesGarants = $unGarantRepository->getLesGarant();

        $this->render(ROOT . "/templates/Contrat/modif", array("title" => "Modification d'un contrat", "lContrat" => $lContrat, "lesApparts" => $lesAppartements, "LesLocataires" => $LesLocataires, "LesGarants" => $LesGarants));
    }

    public function modifTrait(): void
    {
        $AppartementRepository = new AppartementRepository();
        $unGarantRepository = new GarantRepository();
        $unLocataireRepository = new LocataireRepository();
        $lContrat = new Contrat(
            $_POST["idContrat"],
            new DateTime($_POST["debut"]),
            new DateTime($_POST["fin"]),
            $AppartementRepository->getUnAppartement($_POST["lstAppart"]),
            $unGarantRepository->getUnGarant($_POST["lstGarant"]),
            $unLocataireRepository->getUnLocataire($_POST["lstLocataire"]),
            $_POST["montantLoyer"],
            $_POST["montantCharge"],
            $_POST["montantCaution"],
            $_POST["salaire"]
        );
        // on crée une instance de AppartementRepository
        $unContratRepository = new ContratRepository();

        // on appelle la méthode qui permet d'ajouter l'appartement
        // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
        // ret contient true si l'ajout s'est bien passé
        $ret = $unContratRepository->modifContrat($lContrat);
        $lesAppartements = $AppartementRepository->getLesApparts();

        $LesLocataires = $unLocataireRepository->getLesLocataires();

        $LesGarants = $unGarantRepository->getLesGarant();
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $this->render(ROOT . "/templates/Contrat/modif", array("title" => "Modification d'un appartement", "msg" => $msg, "lContrat" => $lContrat, "lesApparts" => $lesAppartements, "LesLocataires" => $LesLocataires, "LesGarants" => $LesGarants));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
            // on crée une instance de AppartementRepository
            $unContratRepository = new ContratRepository();
    
            // on demande au modèle la liste des appartements
            $lesContrats = $unContratRepository->getLesContrats();

            $this->render(ROOT . "/templates/Contrat/modifListe", array("title" => "Liste des contrats", "msg" => $msg, "lesContrats" => $lesContrats));
        }
    }
    public function supprListe(): void
    {
        // on crée une instance de ContratRepository
        $unContratRepository = new ContratRepository();

        // on demande au modèle la liste des contrats
        $lesContrats = $unContratRepository->getLesContrats();

        $this->render(ROOT . "/templates/Contrat/supprListe", array("title" => "Liste des contrats", "lesContrats" => $lesContrats));
    }
    public function supprForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut supprimer
        $idContrat =  $_POST["supprimer"];

        // on crée une instance de AppartementRepository
        $unContratRepository = new ContratRepository();

        // on demande au modèle l'appartement à modifier 
        $lContrat = $unContratRepository->getUnContrat($idContrat);

        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
        // on crée une instance de AppartementRepository

        $this->render(ROOT . "/templates/Contrat/suppr", array(
            "title" => "Suppression d'un contrat", 
            "lContrat" => $lContrat));
    }
    public function supprTrait(): void
    {
        // on crée une instance de AppartementRepository
        $unContratRepository = new ContratRepository();

        $ret = $unContratRepository->supprContrat($_POST["idContrat"]);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre suppression n'a pas été prise en compte</p>";
            // on réaffiche le formulaire

            $this->render(ROOT . "/templates/Contrat/suppr", array(
                "title" => "Suppression d'un contrat", 
                "lContrat" => $unContratRepository->getUnContrat($_POST["idContrat"]),
                "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre suppression a été enregistrée</p>";
            // on crée une instance de ContratRepository
            $unContratRepository = new ContratRepository();
    
            // on demande au modèle la liste des contrats
            $lesContrats = $unContratRepository->getLesContrats();
            

            $this->render(ROOT . "/templates/Contrat/supprliste", array("title" => "Liste des contrat", "lesContrats" => $lesContrats, "msg" => $msg));
        }
    }
};
