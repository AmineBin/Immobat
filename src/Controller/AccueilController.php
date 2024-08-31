<?php
namespace App\Controller;

use App\Controller\Controller;

class AccueilController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function accueil(): void
    {
        $this->render(ROOT . "/templates/Accueil/accueil", array("title" => "Accueil général"));
    }
}
