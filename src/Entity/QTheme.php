<?php

namespace App\Entity;

use App\Repository\QThemeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=QThemeRepository::class)
 */
class QTheme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Length(min=5, minMessage="Le libellé doit faire au moins 5 caractères !")
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }} !"
     * )
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme;

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

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }
}
