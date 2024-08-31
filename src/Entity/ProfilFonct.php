<?php
namespace App\Entity;

use App\Entity\Profil;
use App\Entity\Fonctionnalite;

class ProfilFonct
{

	private Profil $leProfil;
	private Fonctionnalite $laFonct;

	public function __construct($leProfil, $laFonct)
	{
		$this->leProfil = $leProfil;
		$this->laFonct = $laFonct;
	}
	public function getLeProfil(): Profil
	{
		return $this->leProfil;
	}
	public function setLeProfil($leProfil): void
	{
		$this->leProfil = $leProfil;
	}
	public function getLaFonct(): Fonctionnalite
	{
		return $this->laFonct;
	}
	public function setLaFonct($laFonct): void
	{
		$this->laFonct = $laFonct;
	}
}
