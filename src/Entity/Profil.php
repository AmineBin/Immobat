<?php
namespace App\Entity;

class Profil
{
	private ?int $id;
	private ?string $libelle;

	public function __construct($id, $libelle = null)
	{
		$this->id = $id;
		$this->libelle = $libelle;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setId($id): void
	{
		$this->id = $id;
	}
	public function getLibelle(): string
	{
		return $this->libelle;
	}
	public function setLibelle($libelle): void
	{
		$this->libelle = $libelle;
	}
}
