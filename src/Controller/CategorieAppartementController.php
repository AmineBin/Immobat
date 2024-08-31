<?php
namespace App\Controller;

use App\Controller\Controller;
use App\Entity\CategorieAppartement;
use App\Repository\CategorieAppartementRepository;


class CategorieAppartementController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function ajoutForm(): void
    {
        // on appelle la vue pour afficher le formulaire d'ajout d'un appartement
        $this->render(ROOT . "/templates/CategorieAppartement/ajout", 
                array("title" => "Ajout d'un appartement"));
    }
    public function ajoutTrait()
    {
         // Crée une instance de la classe CategorieAppartement
        $unTypeAppart = new CategorieAppartement(
        null,
        $_POST['libelle'],
        );
        // on crée une instance de AppartementRepository
        $uneCategorieAppartementRepository = new CategorieAppartementRepository();

        // on appelle la méthode qui permet d'ajouter l'appartement
        // ret contient false si l'ajout n'a pas pu avoir lieu (erreur)
        // ret contient true si l'ajout s'est bien passé
        
        $ret = $uneCategorieAppartementRepository->ajoutCategorieAppartement($unTypeAppart);

        // Réaffichage du formulaire (la vue Appartement/ajout)
        // ----------------------------------------------------
        // pour le formulaire, on récupère les types d'appartement
        // il faut demander au modèle la liste des types d'appartements pour alimenter la liste déroulante
        // dans le formulaire, on affiche un message d'erreur ou un message de confirmation de l'ajout
        if ($ret == false) {
            // affichage d'un message d'erreur : l'appartement n'a pas été ajouté on doit réafficher les données saisies (on passe un objet à la vue)
            $msg = "<p class='text-danger'>ERREUR : votre categorie n'a pas été enregistré</p>";
            $this->render(ROOT . "/templates/CategorieAppartement/ajout", 
            array("title" => "Ajout d'une catégorie d'appartement", 
            "msg" => $msg, 
            "categ" => $unTypeAppart));
        } else {
            // pas de  : l'appartement n'a pas été ajouté
            $msg = "<p class='text-success'>Votre appartement a été enregistré</p>";
            $this->render(ROOT . "/templates/CategorieAppartement/ajout", 
                array("title" => "Ajout d'un appartement", "msg" => $msg));
        }
    }
}