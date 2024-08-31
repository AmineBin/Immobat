<?php
namespace App\Controller;

use App\Entity\Appartement;
use App\Controller\Controller;
use App\Entity\CategorieAppartement;
use App\Repository\AppartementRepository;
use App\Repository\CategorieAppartementRepository;
use App\Entity\Proprietaire;
use App\Repository\ProprietaireRepository;
use App\Repository\VilleRepository;
use App\Entity\Ville;

class AppartementController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function ajoutForm(): void
    {
        // il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
        $CategorieAppartementRepository = new CategorieAppartementRepository();
        $lesTypesAppartements = $CategorieAppartementRepository->getLesTypes();

        $ProprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $ProprietaireRepository->getLesProprios();

        $VilleRepository = new VilleRepository();
        $lesVilles = $VilleRepository->getLesVilles();
        

        // on appelle la vue pour afficher le formulaire d'ajout d'un appartement
        $this->render(ROOT . "/templates/Appartement/ajout", 
                array("title" => "Ajout d'un appartement",
                "lesTypesApparts" => $lesTypesAppartements,
                "lesProprietaires" => $lesProprietaires, 
                "lesVilles" => $lesVilles));
    }
    public function ajoutTrait()
    {
        // on crée une instance de la classe Appartement à partir des données saisies sur le formulaire
        
        
        $appart = new Appartement(
            null,
            $_POST['rue'],
            $_POST['batiment'],
            $_POST['etage'],
            $_POST['superficie'],
            $_POST['orientation'],
            $_POST['nb_piece'],
            new CategorieAppartement($_POST['lstTypeAppart'], null),
            new Proprietaire($_POST['lstProprietaire'], null, null, null, null, null, null, null),
            new Ville($_POST['lstVille'], null, null)
        );
        
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on appelle la méthode qui permet d'ajouter l'appartement
        // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
        // ret contient true si l'ajout s'est bien passé
        
        $ret = $unAppartRepository->ajoutAppartement($appart);

        // Réaffichage du formulaire (la vue Appartement/ajout)
        // ----------------------------------------------------
        // pour le formulaire, on récupère les types d'appartement
        // il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
        $CategorieAppartementRepository = new CategorieAppartementRepository();
        $lesTypesAppartements = $CategorieAppartementRepository->getLesTypes();

        $ProprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $ProprietaireRepository->getLesProprios();

        $VilleRepository = new VilleRepository();
        $lesVilles = $VilleRepository->getLesVilles();
        if ($_POST['rue'] == "" || $_POST['batiment'] == "" || $_POST['etage'] == "" || $_POST['superficie'] == "" || $_POST['orientation'] == "" || $_POST['nb_piece'] == "" )
        {
            $msg = "<p class='text-danger'>ERREUR : votre appartement n'a pas été enregistré</p>";
            $this->render(ROOT . "/templates/Appartement/ajout", 
            array("title" => "Ajout d'un appartement", 
            "lesTypesApparts" => $lesTypesAppartements, 
            "msg" => $msg, 
            "lAppart" => $appart,
            "lesProprietaires" => $lesProprietaires, 
            "lesVilles" => $lesVilles));
        } else {
        }
        // dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
        if ($ret == false) {
            // affichage d'un message d'erreur : l'appartement n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
            $msg = "<p class='text-danger'>ERREUR : votre appartement n'a pas été enregistré</p>";
            $this->render(ROOT . "/templates/Appartement/ajout", 
            array("title" => "Ajout d'un appartement", 
            "lesTypesApparts" => $lesTypesAppartements, 
            "msg" => $msg, 
            "lAppart" => $appart,
            "lesProprietaires" => $lesProprietaires, 
            "lesVilles" => $lesVilles));
        } else {
            // pas de  : l'appartement n'a pas été ajouté
            $msg = "<p class='text-success'>Votre appartement a été enregistré</p>";
            $this->render(ROOT . "/templates/Appartement/ajout", array("title" => "Ajout d'un appartement", "lesTypesApparts" => $lesTypesAppartements, "msg" => $msg,
            "lesProprietaires" => $lesProprietaires, 
            "lesVilles" => $lesVilles));
        }
    }
    
    public function modifListe(): void
    {
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle la liste des appartements
        $lesApparts = $unAppartRepository->getLesApparts();

        $this->render(ROOT . "/templates/Appartement/modifListe", array("title" => "Liste des appartements", "lesApparts" => $lesApparts));
    }
    public function modifForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut modifier
        $idAppart =  $_POST["lstAppart"];

        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle l'appartement à modifier 
        $lAppart = $unAppartRepository->getUnAppartement($idAppart);

        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
        // on crée une instance de AppartementRepository
        $CategorieAppartementRepository = new CategorieAppartementRepository();
        $lesTypes = $CategorieAppartementRepository->getLesTypes();

        $ProprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $ProprietaireRepository->getLesProprios();

        $VilleRepository = new VilleRepository();
        $lesVilles = $VilleRepository->getLesVilles();

        $this->render(ROOT . "/templates/Appartement/modif", array("title" => "Modification d'un appartement", "lesTypesApparts" => $lesTypes, "lAppart" => $lAppart,"lesProprietaires" => $lesProprietaires,"lesVilles" => $lesVilles));
    }
   
    public function modifTrait(): void
    {
        $lAppart = new Appartement(
            $_POST['idAppart'],
            $_POST['rue'],
            $_POST['batiment'],
            $_POST['etage'],
            $_POST['superficie'],
            $_POST['orientation'],
            $_POST['nb_piece'],
            new CategorieAppartement($_POST['lstTypeAppart'], null),
            new Proprietaire($_POST['lstProprietaire'], null, null, null, null, null, null, null),
            new Ville($_POST['lstVille'], null)
        );
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        $ret = $unAppartRepository->modifAppartement($lAppart);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre modification n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $CategorieAppartementRepository = new CategorieAppartementRepository();
            $lesTypes = $CategorieAppartementRepository->getLesTypes();

            $ProprietaireRepository = new ProprietaireRepository();
            $lesProprietaires = $ProprietaireRepository->getLesProprios();

            $VilleRepository = new VilleRepository();
            $lesVilles = $VilleRepository->getLesVilles();

            $this->render(ROOT . "/templates/Appartement/modif", array("title" => "Modification d'un appartement",  "lesTypesApparts" => $lesTypes, "lAppart" => $lAppart, "lesProprietaires" => $lesProprietaires,"lesVilles" => $lesVilles, "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre modification a été enregistrée</p>";
            // on crée une instance de AppartementRepository
            $unAppartRepository = new AppartementRepository();

            // on demande au modèle la liste des appartements
            $lesApparts = $unAppartRepository->getLesApparts();
            

            $this->render(ROOT . "/templates/Appartement/modifListe", array("title" => "Liste des appartements", "lesApparts" => $lesApparts, "msg" => $msg));
        }
    }
    public function supprListe(): void
    {
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle la liste des appartements
        $lesApparts = $unAppartRepository->getLesApparts();

        $this->render(ROOT . "/templates/Appartement/supprListe", array("title" => "Liste des appartements", "lesApparts" => $lesApparts));
    }
    
    //public function appartVerif(): void
    //{
    //     on crée une instance de AppartementRepository
    //    $unAppartRepository = new AppartementRepository();
    //
    //     on demande au modèle la liste des appartements
    //    $lesApparts = $unAppartRepository->condiSupprAppartement();

    //    $this->render(ROOT . "/templates/Appartement/supprListe", array("title" => "Liste des appartements", "lesApparts" => $lesApparts));
    //}
    public function supprForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut supprimer
        
        $idAppart =  $_POST["supprimer"];
        

        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle l'appartement à modifier 
        $lAppart = $unAppartRepository->getUnAppartement($idAppart);

        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
        // on crée une instance de AppartementRepository
        $CategorieAppartementRepository = new CategorieAppartementRepository();
        $lesTypes = $CategorieAppartementRepository->getLesTypes();

        $ProprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $ProprietaireRepository->getLesProprios();

        $VilleRepository = new VilleRepository();
        $lesVilles = $VilleRepository->getLesVilles();

        $this->render(ROOT . "/templates/Appartement/suppr", array(
            "title" => "Suppression d'un appartement", 
            "lesTypesApparts" => $lesTypes, 
            "lAppart" => $lAppart,
            "lesProprietaires" => $lesProprietaires,
            "lesVilles" => $lesVilles));
        
    }  
    public function supprTrait(): void
    {
        if(isset($_POST["supprimer"]) && $_POST["supprimer"] == "supprimer")
        {
        $lAppart = new Appartement(
            $_POST['idAppart'],
            $_POST['rue'],
            $_POST['batiment'],
            $_POST['etage'],
            $_POST['superficie'],
            $_POST['orientation'],
            $_POST['nb_piece'],
            new CategorieAppartement($_POST['lstTypeAppart'], null),
            new Proprietaire($_POST['lstProprietaire'], null, null, null, null, null, null, null),
            new Ville($_POST['lstVille'], null)

        );
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        $ret = $unAppartRepository->supprAppartement($lAppart);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : votre suppression n'a pas été prise en compte</p>";
            // on réaffiche le formulaire 
            $CategorieAppartementRepository = new CategorieAppartementRepository();
            $lesTypes = $CategorieAppartementRepository->getLesTypes();

            $ProprietaireRepository = new ProprietaireRepository();
            $lesProprietaires = $ProprietaireRepository->getLesProprios();

            $VilleRepository = new VilleRepository();
            $lesVilles = $VilleRepository->getLesVilles();

            $this->render(ROOT . "/templates/Appartement/suppr", array(
                "title" => "Suppression d'un appartement", 
                "lesTypesApparts" => $lesTypes, 
                "lAppart" => $lAppart, 
                "lesProprietaires" => $lesProprietaires, 
                "lesVilles" => $lesVilles, 
                "msg" => $msg));
        } else {
            $msg = "<p class='text-success'>Votre suppression a été enregistrée</p>";
            // on crée une instance de AppartementRepository
            $unAppartRepository = new AppartementRepository();

            // on demande au modèle la liste des appartements
            $lesApparts = $unAppartRepository->getLesApparts();
            

            $this->render(ROOT . "/templates/Appartement/supprListe", array("title" => "Liste des appartements", "lesApparts" => $lesApparts, "msg" => $msg));
        }
        }
        else 
        {
            $this->supprListe();
        }
    }
    public function multiForm(): void
    {
        // on récupère l'appartement sélectionné dans la liste que l'utilisateur veut supprimer
        $idAppart =  $_POST["voir"];

        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle l'appartement à modifier 
        $lAppart = $unAppartRepository->getUnAppartement($idAppart);

        // on doit récupèrer les types d'appartements pour alimenter la liste déroulante du formulaire
        // on crée une instance de AppartementRepository
        $CategorieAppartementRepository = new CategorieAppartementRepository();
        $lesTypes = $CategorieAppartementRepository->getLesTypes();

        $ProprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $ProprietaireRepository->getLesProprios();

        $VilleRepository = new VilleRepository();
        $lesVilles = $VilleRepository->getLesVilles();

        $this->render(ROOT . "/templates/Appartement/listeMulti", array(
            "title" => "Suppression d'un appartement", 
            "lesTypesApparts" => $lesTypes, 
            "lAppart" => $lAppart,
            "lesProprietaires" => $lesProprietaires,
            "lesVilles" => $lesVilles));
    }
    public function liste(): void
    {
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle la liste des appartements
        $lesApparts = $unAppartRepository->getLesApparts();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Appartement/consultListe", array("title" => "Liste des appartements", "lesApparts" => $lesApparts));
    }
    public function appartLibres(): void
    {
        // on crée une instance de AppartementRepository
        $unAppartRepository = new AppartementRepository();

        // on demande au modèle la liste des appartements

        $lesAppartLibres = $unAppartRepository->getLesAppartsLibres();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Appartement/ListeAppartLibres", array("title" => "Liste des appartements libres", "lesAppartLibres" => $lesAppartLibres));
    }
    public function multiListe(): void
    {
        $CategorieAppartementRepository = new CategorieAppartementRepository();
        $lesTypes = $CategorieAppartementRepository->getLesTypes();

        $ProprietaireRepository = new ProprietaireRepository();
        $lesProprietaires = $ProprietaireRepository->getLesProprios();

        $this->render(ROOT . "/templates/Appartement/listeMulti", array(
        "title" => "Liste des appartements", 
        "lesTypesApparts" => $lesTypes, 
        "lesProprietaires" => $lesProprietaires));
    }
};
