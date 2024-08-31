<?php
namespace App\Controller;

use App\Entity\Locataire;
use App\Entity\Impression;
use App\Controller\Controller;
use App\Entity\Ville;
use App\Repository\VilleRepository;
use App\Repository\ProfilRepository;
use App\Repository\ContratRepository;
use App\Repository\LocataireRepository;
use App\Repository\ImpressionRepository;
use App\Entity\CategorieSocioprofessionnelle;
use App\Repository\CategorieSocioprofessionnelleRepository;


class LocataireController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function connexionForm(): void
    {
        $this->render(ROOT . "/templates/locataire/connexion", array("title" => "Connexion"));
    }
    public function ajoutForm(): void
    {
		$villeRepository = new VilleRepository();
		$villes = $villeRepository->getLesVilles();

		$impresionRepository = new ImpressionRepository();
		$impressions  = $impresionRepository->getLesImpressions();

        $categorieSocioprofessionelleRepository = new CategorieSocioprofessionnelleRepository();
		$categorieSocioprofessionnelles = $categorieSocioprofessionelleRepository->getLesCategorieSocioprofessionnelles();

        $this->render(ROOT . "/templates/locataire/ajout", 
        array("title" => "Ajout d'un locataire", 
        "impressions" => $impressions, 
        "villes" => $villes, 
        "CategorieSocioprofessionnelles" => $categorieSocioprofessionnelles));
    }
    public function ajoutTrait(): void
    {
        // on récupère l'id deconnecté
        session_start();

        
        $nom = trim($_POST['nom']);
        
        $prenom = trim($_POST['prenom']);
       
        $email = trim($_POST['email']);
      
        $telephone = trim($_POST['telephone']);
      
        $rue = trim($_POST['rue']);
    
        
        $unLocataire  = new Locataire(
            0,
            $nom,
            $prenom,
            $email,
            $telephone,
            $rue,
            new Ville($_POST["lstVille"]),
            new Impression($_POST["lstImpression"]),
            new CategorieSocioprofessionnelle($_POST["lstCategorieSocioprofessionnelle"])
        );

        $unLocataireRepository = new LocataireRepository();
        $ret = $unLocataireRepository->ajoutLocataire($unLocataire);
        $villeRepository = new villeRepository();
        $villes = $villeRepository->getLesVilles();
		$impressionRepository = new impressionRepository();
		$impressions = $impressionRepository->getLesImpressions();
        $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
		$categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();
        //if ($ret == false || trim($_POST['nom']) == "" || trim($_POST['prenom']) == "") {
		if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : le locataire n'a pas été enregistré</p>";
            $this->render(ROOT . "/templates/locataire/ajout", array("title" => "Ajout d'un locataire", "msg" => $msg, "leLoca" => $unLocataire, "impressions" => $impressions, "CategorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "villes" => $villes));
        } else {
            $msg = "<p class='text-success'>Le locataire a été enregistré</p>";
            $this->render(ROOT . "/templates/locataire/ajout", array("title" => "Ajout d'un locataire", "msg" => $msg, "impressions" => $impressions, "CategorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "villes" => $villes));
        }
    }
    public function modifListe(): void
    {
        // on crée une instance de LocataireRepository
        $unLocataireRepository = new LocataireRepository();

        // on demande au modèle la liste des appartements
        $lesLocataires = $unLocataireRepository->getLesLocataires();

        $this->render(ROOT . "/templates/Locataire/modifListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires));
    }
    public function modifForm(): void
    {
        // on récupère le locataire sélectionné dans la liste que l'utilisateur veut modifier
        $idLocataire =  $_POST["lstLocataire"];

        // on crée une instance de LocataireRepository
        $unLocataireRepository = new LocataireRepository();

        // on demande au modèle le locataire à modifier 
        $leLoca = $unLocataireRepository->getUnLocataire($idLocataire);

        // 
        $villeRepository = new villeRepository();
        $villes = $villeRepository->getLesVilles();
		$impressionRepository = new impressionRepository();
		$impressions = $impressionRepository->getLesImpressions();
        $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
        $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();

        $this->render(ROOT . "/templates/Locataire/modif", array("title" => "Modification d'un locataire", "leLocataire" => $leLoca, "impressions" => $impressions, "CategorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "villes" => $villes));

    }

    public function modifTrait(): void
    {
        $leLoca = new Locataire(
            $_POST['idLocataire'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['rue'],
            new Ville($_POST['lstVille'], null),
            new Impression($_POST['lstImpression'], null),
            new CategorieSocioprofessionnelle($_POST['lstCategorieSocioprofessionnelle'], null),
        );
        // on crée une instance de LocataireRepository
        $unLocataireRepository = new LocataireRepository();

        $ret = $unLocataireRepository->modifLocataire($leLoca);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $villeRepository = new villeRepository();
            $villes = $villeRepository->getLesVilles();
            $impressionRepository = new impressionRepository();
            $impressions = $impressionRepository->getLesImpressions();
            $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
            $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();
            $this->render(ROOT . "/templates/Locataire/modif", array("title" => "Modification d'un locataire", "impressions" => $impressions, "CategorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "villes" => $villes, "leLocataire" => $leLoca,   "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
            // on crée une instance de LocataireRepository
            $unLocataireRepository = new LocataireRepository();

            // on demande au modèle la liste des appartements
            $lesLocataires = $unLocataireRepository->getLesLocataires();

            $this->render(ROOT . "/templates/Locataire/modifListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires, "msg" => $msg));
        }
    }
    public function liste(): void
    {
        // on crée une instance de locataireRepository
        $unLocataireRepository = new LocataireRepository();

        // on demande au modèle la liste des appartements
        $lesLocataires = $unLocataireRepository->getLesLocataires();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Locataire/consultListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires));
    }
    public function supprListe(): void
    {
        // on crée une instance de LocataireRepository
        $unLocataireRepository = new LocataireRepository();

        // on demande au modèle la liste des 
        $lesLocataires = $unLocataireRepository->getLesLocataires();

        $this->render(ROOT . "/templates/Locataire/supprListe", array("title" => "Suppression des locataires", "lesLocataires" => $lesLocataires));

        
    }
    public function supprForm(): void
    {
        // on récupère le locataire sélectionné dans la liste que l'utilisateur veut modifier
        $idLocataire =  $_POST["supprimer"];

        // on crée une instance de LocataireRepository
        $unLocataireRepository = new LocataireRepository();

        // on demande au modèle le locataire à modifier 
        $leLoca = $unLocataireRepository->getUnLocataire($idLocataire);

        // 
        $villeRepository = new villeRepository();
        $lesVilles = $villeRepository->getLesVilles();
		$impressionRepository = new impressionRepository();
		$lesImpressions = $impressionRepository->getLesImpressions();
        $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
        $lesCategorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();

        $this->render(ROOT . "/templates/Locataire/suppr", 
        array("title" => "Suppression d'un locataire",
         "leLoca" => $leLoca, 
         "lesImpressions" => $lesImpressions, "lesCategorieSocioprofessionnelles" => $lesCategorieSocioprofessionnelles, "lesVilles" => $lesVilles));
    }

    public function supprTrait(): void
    {
        $leLoca = new Locataire(
            $_POST['idLocataire'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['rue'],
            new Ville($_POST['lstVille'], null,),
            new Impression($_POST['lstImpression'], null),
            new CategorieSocioprofessionnelle($_POST['lstCategorieSocioprofessionnelle'], null),
        );
        // on crée une instance de LocataireRepository
        $unLocataireRepository = new LocataireRepository();

        if ($unLocataireRepository->condiSupprLocataire($leLoca)){
            $unLocataireRepository = new LocataireRepository();
                $unContratRepository = new ContratRepository();
                $lesContratsLocataire = $unContratRepository->getLesContratsUnLocataire($leLoca);
                foreach ($lesContratsLocataire as $unContratLocataire){
                    $unContratRepository->supprContrat($unContratLocataire->GetId());
                }
            $ret = $unLocataireRepository->supprLocataire($leLoca);
            if ($ret == false) {
                $msg = "<p class='text-danger'>ERREUR : votre suppression n'a pas été prise en compte</p>";
                // on réaffiche le formulaire 
                $villeRepository = new villeRepository();
                $villes = $villeRepository->getLesVilles();
                $impressionRepository = new impressionRepository();
                $impressions = $impressionRepository->getLesImpressions();
                $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
                $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();
                $this->render(ROOT . "/templates/Locataire/suppr", array("title" => "Suppression d'un locataire", "impressions" => $impressions, "CategorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "villes" => $villes, "leLocataire" => $leLoca,   "msg" => $msg));
            } else {
                $msg = "<p class='text-success'>Votre suppression a été enregistrée</p>";
                // on crée une instance de LocataireRepository
                
                // on demande au modèle la liste des locataires
                $lesLocataires = $unLocataireRepository->getLesLocataires();
    
                $this->render(ROOT . "/templates/Locataire/supprListe", array("title" => "Suppression des locataires", "lesLocataires" => $lesLocataires, "msg" => $msg));
            }
        } else {
            $msg = "<p class='text-danger'>Votre suppression n'est pas possible, un contrat est encore en cours</p>";
                // on crée une instance de LocataireRepository
                $unLocataireRepository = new LocataireRepository();
    
                // on demande au modèle la liste des locataires
                $lesLocataires = $unLocataireRepository->getLesLocataires();
    
                $this->render(ROOT . "/templates/Locataire/supprListe", array("title" => "Suppression des locataires", "lesLocataires" => $lesLocataires, "msg" => $msg));
        }

        
    }
    public function verifCondi(): void
    {
        $leLoca = new Locataire(
            $_POST['idLocataire'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['rue'],
            new Ville($_POST['lstVille'], null),
            new Impression($_POST['lstImpression'], null),
            new CategorieSocioprofessionnelle($_POST['lstCategorieSocioprofessionnelle'], null),
        );
        // on crée une instance de LocataireRepository
        $unLocataireRepository = new LocataireRepository();

        $ret = $unLocataireRepository->condiSupprLocataire($leLoca);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : Suppression impossible : il y a un contrat en cours</p>";
            // on réaffiche le formulaire 
            $villeRepository = new villeRepository();
            $villes = $villeRepository->getLesVilles();
            $impressionRepository = new impressionRepository();
            $impressions = $impressionRepository->getLesImpressions();
            $categorieSocioprofessionnelleRepository = new CategorieSocioprofessionnelleRepository();
            $categorieSocioprofessionnelles = $categorieSocioprofessionnelleRepository->getLesCategorieSocioprofessionnelles();
            $this->render(ROOT . "/templates/Locataire/", array("title" => "supprimer d'un locataire", "impressions" => $impressions, "CategorieSocioprofessionnelles" => $categorieSocioprofessionnelles, "villes" => $villes, "leLocataire" => $leLoca,   "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
            // on crée une instance de LocataireRepository
            $unLocataireRepository = new LocataireRepository();

            // on demande au modèle la liste des locataires
            $lesLocataires = $unLocataireRepository->getLesLocataires();

            $this->render(ROOT . "/templates/Locataire/modifListe", array("title" => "Liste des locataires", "lesLocataires" => $lesLocataires, "msg" => $msg));
        }
    }
}