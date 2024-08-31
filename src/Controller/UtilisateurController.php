<?php
namespace App\Controller;

use App\Entity\Profil;
use App\Entity\Utilisateur;
use App\Controller\Controller;
use App\Repository\ProfilRepository;
use App\Repository\UtilisateurRepository;

class UtilisateurController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function connexionForm(): void
    {
        $this->render(ROOT . "/templates/utilisateur/connexion", array("title" => "Connexion"));
    }
	public function connexionTrait(): void
	{
		$utilRepository = new UtilisateurRepository();
		$unUtilisateur = $utilRepository->connexionUtilisateur($_POST['pseudo'], $_POST['motdepasse']);
		if ($unUtilisateur == null) {
			// le pseudo est incorrect
			$msgErr = "pseudo et/ou identifiant incorrect(s)";
			$this->render(ROOT . "/templates/utilisateur/connexion", array("title" => "Connexion", "msgErr" => $msgErr));
		} else {
			// le pseudo est valide
			if (password_verify($_POST['motdepasse'], $unUtilisateur->getMotDePasse())) {
				// le mot de passe est valide
				// on enregistre dans une variable de session le profil et l'id de l'utilisateur
				session_start();
				$_SESSION['profil'] = $unUtilisateur->getProfil()->getId();
				$_SESSION['id'] = $unUtilisateur->getId();
	
				// on récupère les fonctionnalités auxquelles l'utilisateur connecté a droit
				$lesFonctionnalites = $utilRepository->fonctUtilisateur($unUtilisateur->getProfil()->getId());
	
				// on appelle la méthode qui génére la barre de navigation contenant les options du menu
				$this->creerOptionsMenus($unUtilisateur->getProfil()->getId(), $lesFonctionnalites);
	
				// on affiche la page d'accueil
				$this->render(ROOT . "/templates/accueil/accueil", array("title" => "Accueil"));
			} else {
				// le mot de passe est invalide
				$msgErr = "identifiant et/ou mot de passe incorrect";
				$this->render(ROOT . "/templates/utilisateur/connexion", array("title" => "Connexion", "msgErr" => $msgErr));
			}
		}
	}
public function creerOptionsMenus($profil, $lesFonc): void
{
	$utilRepository = new UtilisateurRepository();
	$lesThemes = $utilRepository->fonctTheme($profil);
	// on crée la barre de navigation contenant les options du menu
	$contenuHTML = "";
	// on ajoute l'option de déconnexion
	$contenuHTML = $contenuHTML .
		"<div class='collapse navbar-collapse' id='navbarSupportedContent'>".
			"<ul class='navbar-nav me-auto mb-2 mb-lg-0'>" .
				"<li class='nav-item'>" .
					"<a class='nav-link active' aria-current='page' href='/'>Deconnexion</a>" .
				"</li>";
	//on affiche les fonctionnalités auxquelles le profil de l'utilisateur a droit
	foreach ($lesThemes as $unTheme) {

		$theme = $unTheme->getTheme();
		$contenuHTML = $contenuHTML . 
			"<li class='nav-item dropdown'>".
			"<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>". ucfirst($theme)."</a>".
			"<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>";
			foreach($lesFonc as $uneFonc){
				if ($theme == $uneFonc->getTheme()) {
					$contenuHTML = $contenuHTML . "<li>"."<a class='dropdown-item' href='/" . $uneFonc->getTheme() . "/" . $uneFonc->getAction() . "'>"
					. $uneFonc->getLibelle() . "</a>"."</li>";
				}
			}
			$contenuHTML = $contenuHTML . "</ul>"."</li>";
	}
	$contenuHTML = $contenuHTML . "</ul></div>";
	// on crée un fichier contenant le code html que l'on vient de générer, c’est-à-dire les options du menu
	// ce fichier a pour nom navn.html où n est l'id du profil de l'utilisateur
	$nomFichier = "nav" . $profil;
	$fic = fopen(ROOT . '/templates/' . $nomFichier . '.html', 'w');
	fwrite($fic, $contenuHTML);
	fclose($fic);
}
    public function ajoutForm(): void
    {
		$unProfRepository = new ProfilRepository();

		$lesProfils = $unProfRepository->getLesProfils();
		
        $this->render(ROOT . "/templates/utilisateur/ajout", array("title" => "Ajout d'un utilisateur", "lesProfils" => $lesProfils));
    }
    public function ajoutTrait(): void
    {
        // on récupère l'id de l'utilisateur connecté
        session_start();

        // on génère le pseudo et le mot de passe
        $nom = trim($_POST['nom']);
        $nom = strtolower($nom);
        $prenom = trim($_POST['prenom']);
        $prenom = strtolower($prenom);
        $pseudo = substr($nom, 0, 2) . date("y") . substr($prenom, 0, 2);
        $motDePasse = "AK" . substr($nom, 0, 2) . "B1@8T" . substr($prenom, 0, 2) . "#";
        // on crypte le mot de passe
        $motDePasseHasche = password_hash($motDePasse, PASSWORD_BCRYPT);
        $unUtilisateur = new Utilisateur(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $pseudo,
            $motDePasseHasche,
            new Profil($_POST['lstProfil'])
        );
        $unUtilisateurRepository = new UtilisateurRepository();
        $ret = $unUtilisateurRepository->ajoutUtilisateur($unUtilisateur);
        if ($ret == false) {
            $msg = "<p class='text-danger'>ERREUR : l'utilisateur n'a pas été enregistré</p>";
            $this->render(ROOT . "/templates/utilisateur/ajout", array("title" => "Ajout d'un utilisateur", "msg" => $msg, "leUtil" => $unUtilisateur));
        } else {
            $msg = "<p class='text-success'>L'utilisateur a été enregistré</p>";
            $this->render(ROOT . "/templates/utilisateur/ajout", array("title" => "Ajout d'un utilisateur", "msg" => $msg));
        }
    }
	public function liste()
	{
		// on crée une instance de AppartementRepository
        $unUtilisateurRepository = new UtilisateurRepository();

        // on demande au modèle la liste des appartements
        $lesUtilisateurs = $unUtilisateurRepository->getLesUtilisateurs();

        // on passe les données à la vue pour qu'elle les affiche
        $this->render(ROOT . "/templates/Utilisateur/consultListe", array("title" => "Liste des utilisateurs", "lesUtilisateurs" => $lesUtilisateurs));
	}
}