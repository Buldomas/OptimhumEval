<?php

namespace App\Entity;

use App\Repository\QFormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QFormationRepository::class)
 */
class QFormation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, minMessage="Le libellé doit faire au moins {{ min }} caractères !")
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }} !"
     * )
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=formation::class, inversedBy="qFormations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getFormation(): ?formation
    {
        return $this->formation;
    }

    public function setFormation(?formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }
}
