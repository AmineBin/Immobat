<?php
namespace App\Entity;
class Fonctionnalite
{
	private ?int $id;
	private ?string $libelle;
	private ?string $theme;
	private ?string $action;

	public function __construct($id = null, $libelle, $theme, $action)
	{
		$this->id = $id;
		$this->libelle = $libelle;
		$this->theme = $theme;
		$this->action = $action;
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
	public function getTheme(): string
	{
		return $this->theme;
	}
	public function setTheme($theme): void
	{
		$this->theme = $theme;
	}
	public function getAction(): string
	{
		return $this->action;
	}
	public function setAction($action): void
	{
		$this->action = $action;
	}
}
