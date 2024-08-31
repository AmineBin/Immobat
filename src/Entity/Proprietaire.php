<?php
namespace App\Entity;
class Proprietaire
{
	private ?int $id;
	private ?string $nom;
    private ?string $prenom;
    private ?string $email;
	private ?string $telephone;
    private ?modeGestion $leModeDeGestion;
	private ?ville $laVille;
	private ?string $rue;

	public function __construct(?int $id,?string $nom,?string $prenom,?string $email,?string $telephone,?modeGestion $leModeDeGestion,?ville $laVille,?string $rue)
	{
		$this->id = $id;
		$this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
		$this->telephone = $telephone;
        $this->leModeDeGestion = $leModeDeGestion;
        $this->laVille = $laVille;
		$this->rue = $rue;
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
	public function getEmail(): string
	{
		return $this->email;
	}
	public function setEmail($email): void
	{
		$this->email = $email;
	}
	public function getTelephone(): string
	{
		return $this->telephone;
	}
	public function setTelephone($telephone): void
	{
		$this->telephone = $telephone;
	}
	public function getLeModeDeGestion(): modeGestion
	{
		return $this->leModeDeGestion;
	}
	public function setLeModeDeGestion($leModeDeGestion): void
	{
		$this->leModeDeGestion = $leModeDeGestion;
	}
	public function getLaVille(): Ville
	{
		return $this->laVille;
	}
	public function setLaVille($laVille): void
	{
		$this->laVille = $laVille;
	}
	public function getRue(): string
	{
		return $this->rue;
	}
	public function setRue($rue): void
	{
		$this->rue = $rue;
	}
}
