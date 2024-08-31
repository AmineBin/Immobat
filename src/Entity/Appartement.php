<?php
namespace App\Entity;

use App\Entity\CategorieAppartement;
use App\Entity\Proprietaire;

class Appartement
{
	private ?int $id;
	private ?string $rue;
	private ?int $batiment;
	private ?int $etage;
	private ?float $superficie;
	private ?string $orientation;
	private ?int $nbPiece;
	private ?CategorieAppartement $leCategorieAppartement;
	private ?Proprietaire $proprietaire;
	private ?Ville $laVille;



	public function __construct(?int $id, string $rue, int $batiment,int $etage, float $superficie, string $orientation, int $nbPiece, CategorieAppartement $leCategorieAppartement, Proprietaire $proprietaire, Ville $laVille)

	{
		$this->id = $id;
		$this->rue = $rue;
		$this->batiment = $batiment;
		$this->etage = $etage;
		$this->superficie = $superficie;
		$this->orientation = $orientation;
		$this->nbPiece = $nbPiece;
		$this->leCategorieAppartement = $leCategorieAppartement;
		$this->proprietaire = $proprietaire;
		$this->laVille = $laVille;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setId(int $id): void
	{
		$this->id = $id;
	}
	public function getRue(): string
	{
		return $this->rue;
	}
	public function setRue(string $rue): void
	{
		$this->rue = $rue;
	}
	public function getBatiment(): string
	{
		return $this->batiment;
	}
	public function setBatiment(int $batiment): void
	{
		$this->batiment = $batiment;
	}
	public function getEtage(): string
	{
		return $this->etage;
	}
	public function setEtage(int $etage): void
	{
		$this->etage = $etage;
	}
	public function getSuperficie(): float
	{
		return $this->superficie;
	}
	public function setSuperficie(float $superficie): void
	{
		$this->superficie = $superficie;
	}
	public function getOrientation(): string
	{
		return $this->orientation;
	}
	public function setOrientation(string $orientation): void
	{
		$this->orientation = $orientation;
	}
	public function getNbPiece(): int
	{
		return $this->nbPiece;
	}
	public function setNbPiece(int $nbPiece): void
	{
		$this->nbPiece = $nbPiece;
	}
	public function getCategorieAppartement(): CategorieAppartement
	{
		return $this->leCategorieAppartement;
	}
	public function setCategorieAppartement(CategorieAppartement $leCategorieAppartement): void
	{
		$this->leCategorieAppartement = $leCategorieAppartement;
	}
	public function getProprietaire(): Proprietaire
	{
		return $this->proprietaire;
	}
	public function setProprietaire(Proprietaire $proprietaire): void
	{
		$this->proprietaire = $proprietaire;
	}
	public function getVille(): Ville
	{
		return $this->laVille;
	}
	public function setVille(Ville $laVille): void
	{
		$this->laVille = $laVille;
	}



}
