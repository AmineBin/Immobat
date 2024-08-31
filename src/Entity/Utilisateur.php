<?php
namespace App\Entity;

use App\Entity\Profil;

class Utilisateur
{
	private ?int $id;
	private ?string $nom;
	private ?string $prenom;
	private ?string $pseudo;
	private ?string $motDePasse;
	private ?Profil $leProfil;

	public function __construct($id, $nom = null, $prenom = null, $pseudo = null, $motDePasse = null, $leProfil = null)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->pseudo = $pseudo;
		$this->motDePasse = $motDePasse;
		$this->leProfil = $leProfil;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setId($id): void
	{
		$this->id = $id;
	}
	public function getNom(): string
	{
		return $this->nom;
	}
	public function setNom($nom): void
	{
		$this->nom = $nom;
	}
	public function getPrenom(): string
	{
		return $this->prenom;
	}
	public function setPrenom($prenom): void
	{
		$this->prenom = $prenom;
	}
	public function getPseudo(): string
	{
		return $this->pseudo;
	}
	public function setPseudo($pseudo): void
	{
		$this->pseudo = $pseudo;
	}
	public function getMotDePasse(): string
	{
		return $this->motDePasse;
	}
	public function setMotDePasse($motDePasse): void
	{
		$this->motDePasse = $motDePasse;
	}
	public function getProfil(): ?Profil
	{
		return $this->leProfil;
	}
	public function setProfil($leProfil): void
	{
		$this->leProfil = $leProfil;
	}
}
