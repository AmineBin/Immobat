<?php
namespace App\Entity;

class Garant
{
	private int $id;
	private string $nom;
	private string $prenom;

	public function __construct(int $id, string $nom, string $prenom)
	{
		$this->id = $id;
		$this->nom = $nom;
		$this->prenom = $prenom;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setId(int $id): void
	{
		$this->id = $id;
	}
	public function getNom(): string
	{
		return $this->nom;
	}
	public function setNom(string $nom): void
	{
		$this->nom = $nom;
	}
	public function getPrenom(): string
	{
		return $this->prenom;
	}
	public function setPrenom(string $prenom): void
	{
		$this->prenom = $prenom;
	}
}
