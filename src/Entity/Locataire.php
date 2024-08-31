<?php
namespace App\Entity;
class Locataire
{
    private  ?int $id;
	private ?string $nom;
	private ?string $prenom;
	private ?string $email;
	private ?string $telephone;
	private ?string $rue;
	private ?Ville $laVille;
	private ?Impression $leImpression;
    private ?CategorieSocioprofessionnelle $leCategorieSocioprofessionnelle;


    public function __construct($id, 
								$nom = null, 
								$prenom = null,
								$email = null,
								$telephone = null,
								$rue = null,
								$laVille = null,
								$leImpression = null,
								$leCategorieSocioprofessionnelle = null)
    {
        $this->id = $id;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->email = $email;
		$this->telephone = $telephone;
		$this->rue = $rue;
		$this->laVille = $laVille;
		$this->leImpression = $leImpression;
		$this->leCategorieSocioprofessionnelle = $leCategorieSocioprofessionnelle;
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
	public function getRue(): string
	{
		return $this->rue;
	}
	public function setRue($rue): void
	{
		$this->rue = $rue;
	}
	public function getVille(): ?Ville
	{
		return $this->laVille;
	}
	public function setVille($laVille): void
	{
		$this->laVille = $laVille;
	} 
	public function getImpression(): ?Impression
	{
		return $this->leImpression;
	}
	public function setImpression($leImpression): void
	{
		$this->leImpression = $leImpression;
	}
    public function getCategorieSocioprofessionnelle(): ?CategorieSocioprofessionnelle
	{
		return $this->leCategorieSocioprofessionnelle;
	}
	public function setCategorieSocioprofessionnelleImpression($leCategorieSocioprofessionnelle): void
	{
		$this->leCategorieSocioprofessionnelle = $leCategorieSocioprofessionnelle;
	}
}