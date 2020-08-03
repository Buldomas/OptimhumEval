<?php

namespace App\Entity;

use App\Repository\QModuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=QModuleRepository::class)
 */
class QModule
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
     * @ORM\Column(type="integer", options={"default":5})
     * 
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      notInRangeMessage = "La note doit être comprise entre {{ min }} et {{ max }} !"
     * )
     */
    private $note = 5;

    /**
     * @ORM\ManyToOne(targetEntity=module::class, inversedBy="qModules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $module_id;

    public function __construct()
    {
        $this->note = 5;
    }
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

    public function getModuleId(): ?module
    {
        return $this->module_id;
    }

    public function setModuleId(?module $module_id): self
    {
        $this->module_id = $module_id;

        return $this;
    }
}
