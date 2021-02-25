<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *        routePrefix="/admin",
 *       collectionOperations={"get", "post"},
 *       itemOperations={"get","put"},
 *       normalizationContext={"groups"={"compte:read"}},
 *       denormalizationContext={"groups"={"compte:write"}}
 * )
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 * @UniqueEntity("code", message="ce code existe deja")
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("compte:read")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Groups({"compte:read", "compte:write"})
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Groups({"compte:read", "compte:write"})
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups({"compte:read", "compte:write"})
     */
    private $createAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="compte")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, inversedBy="compte", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

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

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }
}
