<?php
namespace App\Controller;
abstract class Controller
{
	protected function __construct()
	{
	}
	public function render(string $nomVue, array $lesDonnees = [])
	{
		if (file_exists($nomVue . '.php') == true) {
			// on appelle la méthode extract qui va affecter automatiquement les valeurs fournies du tableau 
			// dans des variables dont le nom est celui de la clé
			extract($lesDonnees);

			// on appelle la fonction php ob_start qui démarre la temporisation de sortie. 
			// A partir de cette instruction aucune donnée, hormis les en-têtes, n'est envoyée au navigateur, 
			// elles sont mises temporairement "en tampon" (= stockées en mémoire). 
			ob_start();

			// on inclut le contenu de la vue dont le nom est passé en paramètre
			require_once($nomVue . '.php');

			// Le contenu du tampon (ce qui est en mémoire) est mis dans la variable $contenuVue
			$contenuVue = ob_get_clean();
			require_once(ROOT . '/templates/template.php');
		} else {
			// la vue passée en paramètre n'existe pas
			http_response_code(404);
			echo ("<h2> Vue $nomVue indisponible</h2>");
		}
	}
}
