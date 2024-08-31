<?php
namespace App\Controller;

use App\Controller\Controller;
use App\Entity\Proprietaire;
use App\Repository\ProprietaireRepository;
use App\Entity\Ville;
use App\Repository\VilleRepository;
use App\Entity\ModeGestion;
use App\Repository\ModeGestionRepository;

class ProprietaireController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function ajoutForm()
    {
        // il faut demander au modèle la liste des ville et la mode de gestion pour alimenter la liste déroulante
        $modeGestionRepository = new ModeGestionRepository();
        $lesModes = $modeGestionRepository->getModeGestion();
        $villeRepository = new VilleRepository();
        $lesVilles = $villeRepository->getLesVilles();

        // on appelle la vue pour afficher le formulaire d'ajout d'un proprietaire
        $this->render(ROOT . "/templates/Proprietaire/ajout", array("title" => "Ajout d'un proprietaire", "lesModes" => $lesModes, "lesVilles" => $lesVilles));
    }
    public function ajoutTrait()
    {
        // on crée une instance de la classe proprietaire à partir des données saisies sur le formulaire
        $proprio = new Proprietaire(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['nbPiece'],
            new ModeGestion($_POST['lstModeGestion'], null),
            new Ville($_POST['lstVille'], null),
            $_POST['rue']
        );
        // on crée une instance de ProrietaireRepository
        $unProprioRepository = new ProprietaireRepository();
        $ret = $unProprioRepository->verificationProprioIdentique($proprio);

        if ($ret == false){
            // on appelle la méthode qui permet d'ajouter le proprietaire
            // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
            // ret contient true si l'ajout s'est bien passé
            $ret = $unProprioRepository->ajoutProprietaire($proprio);

                    // Réaffichage du formulaire (la vue proprietaire/ajout)
            // ----------------------------------------------------
            // pour le formulaire, on récupère les Villes et la mode de gestion 
            // il faut demander au modèle la liste des Villes et la liste des modes de gestions  pour alimenter la liste déroulante
            $modeGestionRepository = new ModeGestionRepository();
            $lesModes = $modeGestionRepository->getModeGestion();
            $villeRepository = new VilleRepository();
            $lesVilles = $villeRepository->getLesVilles();
            // dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
            if ($ret == false) {
                // affichage d'un message d'erreur : le proprietaire n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
                $msg = "<p class='text-danger'>ERREUR : le proprietaire n'a pas été enregistré</p>";
                $this->render(ROOT . "/templates/Proprietaire/ajout", array("title" => "Ajout d'un proprietaire","lesModes" => $lesModes, "lesVilles" => $lesVilles, "msg" => $msg, "leProprio" => $proprio));
            } else {
                // pas de  : l'appartement n'a pas été ajouté
                $msg = "<p class='text-success'>le proprietaire a été enregistré</p>";
                $this->render(ROOT . "/templates/Proprietaire/ajout", array("title" => "Ajout d'un proprietaire","lesModes" => $lesModes, "lesVilles" => $lesVilles, "msg" => $msg));
            }
        }
        else{
            $modeGestionRepository = new ModeGestionRepository();
            $lesModes = $modeGestionRepository->getModeGestion();
            $villeRepository = new VilleRepository();
            $lesVilles = $villeRepository->getLesVilles();
            // affichage d'un message d'erreur : le proprietaire n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
            $msg = "<p class='text-danger'>ERREUR : Le propriétaire ne peut pas être enregistré car il y a déjà un propriétaire avec le même nom, le même prénom et la même ville</p>";
            $this->render(ROOT . "/templates/Proprietaire/ajout", array("title" => "Ajout d'un proprietaire","lesModes" => $lesModes, "lesVilles" => $lesVilles, "msg" => $msg, "leProprio" => $proprio));
        }
    }
    public function liste()
    {
        // on crée une instance de ProprietaireRepository
        $unProprioRepository = new ProprietaireRepository();

        // on demande au modèle la liste des proprietaire
        $lesProprios = $unProprioRepository->getLesProprios();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Proprietaire/liste", array("title" => "Liste des proprietaire", "lesProprios" => $lesProprios));
    }
    public function modifListe()
    {
        // on crée une instance de ProprietaireRepository
        $unProprioRepository = new ProprietaireRepository();

        // on demande au modèle la liste des proprietaires
        $lesProprios = $unProprioRepository->getLesProprios();

        $this->render(ROOT . "/templates/Proprietaire/modifListe", array("title" => "Modification d'un propriétaire", "lesProprios" => $lesProprios));
    }
    public function modifForm()
    {
        // on récupère le proprietaire sélectionné dans la liste que l'utilisateur veut modifier
        $idProprio =  $_POST["lstProprietaire"];

        // on crée une instance de ProprietaireRepository
        $unProprioRepository = new ProprietaireRepository();

        // on demande au modèle le proprietaire à modifier 
        $leProprio = $unProprioRepository->getUnProprietaire($idProprio);

        // il faut demander au modèle la liste des ville et la mode de gestion pour alimenter la liste déroulante
        
        $this->render(ROOT . "/templates/Proprietaire/modif", array("title" => "Modification d'un propriétaire", "lesModes" => $lesModes, "lesVilles" => $lesVilles, "leProprio" => $leProprio));

    }

    public function modifTrait()
    {
        // on crée une instance de la classe proprietaire à partir des données saisies sur le formulaire
        $proprio = new Proprietaire(
            $_POST['idProprio'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            new ModeGestion($_POST['lstModeGestion']),
            new Ville($_POST['lstVille']),
            $_POST['rue']
        );

        // on crée une instance de AppartementRepository
        $unProprioRepository = new ProprietaireRepository();

        $ret = $unProprioRepository->verifProprioIdentique($proprio);
        if ($ret == false){
            // on appelle la méthode qui permet d'ajouter le proprietaire
            // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
            // ret contient true si l'ajout s'est bien passé
            $ret = $unProprioRepository->modifProprietaire($proprio);
            if ($ret == false) {
                $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
                // on réaffiche le formulaire 
                $modeGestionRepository = new ModeGestionRepository();
                $lesModes = $modeGestionRepository->getModeGestion();
                $villeRepository = new VilleRepository();
                $lesVilles = $villeRepository->getLesVilles();
    
                $this->render(ROOT . "/templates/Proprietaire/modif", array("title" => "Modification d'un propriétaire", "lesModes" => $lesModes, "lesVilles" => $lesVilles, "msg" => $msg, "leProprio" => $proprio));
            } else {
                $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
                // on crée une instance de AppartementRepository
            
                // on crée une instance de ProprietaireRepository
                $unProprioRepository = new ProprietaireRepository();

            // on demande au modèle la liste des proprietaires
            $lesProprios = $unProprioRepository->getLesProprios();

            $this->render(ROOT . "/templates/Proprietaire/modifListe", array("title" => "Modifier un propriétaire", "lesProprios" => $lesProprios));
            }
        } else {
            $modeGestionRepository = new ModeGestionRepository();
            $lesModes = $modeGestionRepository->getModeGestion();
            $villeRepository = new VilleRepository();
            $lesVilles = $villeRepository->getLesVilles();
            // affichage d'un message d'erreur : le proprietaire n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
            $msg = "<p class='text-danger'>ERREUR : Le propriétaire ne peut pas être modifiée car il y a déjà un propriétaire avec le même nom, le même prénom et la même ville<</p>";
            $this->render(ROOT . "/templates/Proprietaire/modif", array("title" => "Modification d'un propriétaire", "lesModes" => $lesModes, "lesVilles" => $lesVilles, "msg" => $msg, "leProprio" => $proprio));
        }
    }
    public function suppressionListe(){
        // on crée une instance de ProprietaireRepository
        $unProprioRepository = new ProprietaireRepository();

        // on demande au modèle la liste des proprietaires
        $lesProprios = $unProprioRepository->getLesProprios();

        $this->render(ROOT . "/templates/Proprietaire/supprimerListe", array("title" => "Supprimer un propriétaire", "lesProprios" => $lesProprios));
    }
    public function suppressionForm(){
        $idProprio =  $_POST["supprimer"];

        $unProprioRepository = new ProprietaireRepository();

        // on demande au modèle le proprietaire à modifier 
        $leProprio = $unProprioRepository->getUnProprietaire($idProprio);

        // il faut demander au modèle la liste des ville et la mode de gestion pour alimenter la liste déroulante
        $modeGestionRepository = new ModeGestionRepository();
        $lesModes = $modeGestionRepository->getModeGestion();
        $villeRepository = new VilleRepository();
        $lesVilles = $villeRepository->getLesVilles();
        
        $this->render(ROOT . "/templates/Proprietaire/supprimer", array("title" => "Suppression d'un propriétaire", "lesModes" => $lesModes, "lesVilles" => $lesVilles, "leProprio" => $leProprio));
    }

    public function suppressionTrait()
    {
        // on crée une instance de la classe proprietaire à partir des données saisies sur le formulaire
        $proprio = new Proprietaire(
            $_POST['idProprio'],
            null,
            null,
            null,
            null,
            new ModeGestion(null),
            new Ville(null),
            null
        );

        // on crée une instance de AppartementRepository
        $unProprioRepository = new ProprietaireRepository();
        
        $ret = $unProprioRepository->existeContrat($proprio);
        if ($ret == true){
            // on appelle la méthode qui permet d'ajouter le proprietaire
            // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
            // ret contient true si l'ajout s'est bien passé
            $ret = $unProprioRepository->supprimProprietaire($proprio);
            if ($ret == false) {
                $msg = "<p class='text-danger'>ERREUR : votre suppression n'a pas été prise en compte</p>";
                // on réaffiche le formulaire 
                $modeGestionRepository = new ModeGestionRepository();
                $lesModes = $modeGestionRepository->getModeGestion();
                $villeRepository = new VilleRepository();
                $lesVilles = $villeRepository->getLesVilles();
    
                $this->render(ROOT . "/templates/Proprietaire/supprimer", array("title" => "Suppression d'un propriétaire", "lesModes" => $lesModes, "lesVilles" => $lesVilles, "msg" => $msg, "leProprio" => $proprio));
            } else {
                $msg = "<p class='text-success'>Votre suppression a été effectué</p>";
                // on crée une instance de AppartementRepository
            
                // on crée une instance de ProprietaireRepository
                $unProprioRepository = new ProprietaireRepository();
                
                // on demande au modèle la liste des proprietaires
                $lesProprios = $unProprioRepository->getLesProprios();

            $this->render(ROOT . "/templates/Proprietaire/supprimerListe", array("title" => "Supprimer un propriétaire","msg" => $msg, "lesProprios" => $lesProprios));
            }
        } else {
                // on crée une instance de ProprietaireRepository
                $unProprioRepository = new ProprietaireRepository();
                // on demande au modèle la liste des proprietaires
                $lesProprios = $unProprioRepository->getLesProprios();
            // affichage d'un message d'erreur : le proprietaire n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
            $msg = "<p class='text-danger'>ERREUR : Le propriétaire ne peut pas être supprimée car tous les contrats de location de ses appartements ne sont pas terminés</p>";
            $this->render(ROOT . "/templates/Proprietaire/supprimerListe", array("title" => "Supprimer un propriétaire","msg" => $msg, "lesProprios" => $lesProprios));

        }
    }
}