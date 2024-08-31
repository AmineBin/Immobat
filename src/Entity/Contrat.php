<?php
namespace App\Entity;

use App\Entity\Appartement;
use App\Entity\Garant;
use App\Entity\Locataire;
use DateTime;

class Contrat
{
	private int $id;
	private DateTime $debut;
	private ?DateTime $fin;
    private Appartement $appartement;
    private Garant $garant;
    private Locataire $locataire;
    private int $montantLoyerHC;
    private int $montantCharge;
    private int $montantCaution;
    private int $salaireLocataire;

	public function __construct(int $id, DateTime $debut, ?DateTime $fin, Appartement $appartement, Garant $garant, Locataire $locataire, int $montantLoyerHC, int $montantCharge, int $montantCaution, int $salaireLocataire)
    {
        $this->id = $id;
        $this->debut = $debut;
        $this->fin = $fin;
        $this->appartement = $appartement;
        $this->garant = $garant;
        $this->locataire = $locataire;
        $this->montantLoyerHC = $montantLoyerHC;
        $this->montantCharge = $montantCharge;
        $this->montantCaution = $montantCaution;
        $this->salaireLocataire = $salaireLocataire;
    }
    public function GetId(): int
    {
        return $this->id;
    }
    public function SetId(int $id): void
    {
        $this->id = $id;
    }
    public function GetDebut(): DateTime
    {
        return $this->debut;
    }
    public function SetDebut(DateTime $debut): void
    {
        $this->debut = $debut;
    }
	public function GetFin(): ?DateTime
	{
		return $this->fin;
	}
	public function SetFin(DateTime $fin): void
	{
		$this->fin = $fin;
	}
    public function GetAppartement(): Appartement
    {
        return $this->appartement;
    }
    public function SetAppartement(Appartement $appartement): void
    {
        $this->appartement = $appartement;
    }
    public function GetGarant(): Garant
    {
        return $this->garant;
    }
    public function SetGarant(Garant $garant): void
    {
        $this->garant = $garant;
    }
    public function GetLocataire(): Locataire
    {
        return $this->locataire;
    }
    public function SetLocataire(Locataire $locataire): void
    {
        $this->locataire = $locataire;
    }
    public function GetMontantLoyerHC(): int
    {
        return $this->montantLoyerHC;
    }
    public function SetMontantLoyerHC(int $montantLoyerHC): void
    {
        $this->montantLoyerHC = $montantLoyerHC;
    }
    public function GetMontantCharge(): int
    {
        return $this->montantCharge;
    }
    public function SetMontantCharge(int $montantCharge): void
    {
        $this->montantCharge = $montantCharge;
    }
    public function GetMontantCaution(): int
    {
        return $this->montantCaution;
    }
    public function SetMontantCaution(int $montantCaution): void
    {
        $this->montantCaution = $montantCaution;
    }
    public function GetSalaireLocataire(): int
    {
        return $this->salaireLocataire;
    }
    public function SetSalaireLocataire(int $salaireLocataire): void
    {
        $this->salaireLocataire = $salaireLocataire;
    }
}
