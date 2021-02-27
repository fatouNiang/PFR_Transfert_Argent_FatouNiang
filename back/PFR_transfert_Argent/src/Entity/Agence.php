<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *   @ApiResource(
 *       routePrefix="/admin",
 *       collectionOperations={"get", "post"},
 *       itemOperations={"get","put"},
 *       normalizationContext={"groups"={"agence:read"}},
 *       denormalizationContext={"groups"={"agence:write"}}
 * )
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 * @UniqueEntity("nom", message="ce nom existe deja")

 */
class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("agence:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"agence:write" ,"agence:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"agence:write" ,"agence:read"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Groups({"agence:write" ,"agence:read"})
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="agences")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:write", "user:read", "agence:write"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Compte::class, mappedBy="agence", cascade={"persist", "remove"})
     */
    private $compte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(Compte $compte): self
    {
        // set the owning side of the relation if necessary
        if ($compte->getAgence() !== $this) {
            $compte->setAgence($this);
        }

        $this->compte = $compte;

        return $this;
    }
}
