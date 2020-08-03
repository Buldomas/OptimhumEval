<?php

namespace App\Entity;

use App\Entity\Theme;
use App\Entity\Module;
use App\Entity\QFormation;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"titre"},
 *  message="Il y a déjà un thème avec ce titre !"
 * )
 */
class Formation
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
     * @Assert\Length(min="5", minMessage="Le titre doit faire au moins {{ min }} caractères !")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Length(min="10", minMessage="Le sous-titre doit faire au moins {{ min }} caractères !")
     */
    private $stitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min="25", minMessage="La description doit faire au moins {{ min }} caractères !")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=theme::class, inversedBy="formations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme;

    /**
     * @ORM\ManyToMany(targetEntity=module::class, inversedBy="formations")
     */
    private $modules;

    /**
     * @ORM\OneToMany(targetEntity=QFormation::class, mappedBy="formation", orphanRemoval=true)
     */
    private $qFormations;


    /*******************************************/
    /* Fonctions pour le HasLifecycleCallbacks */
    /*******************************************/

    /**
     * Permet d'initialiser le SLUG
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->titre . ' ' . $this->stitre);
        }
    }
    /***************************************************/
    /* FIN des Fonctions pour le HasLifecycleCallbacks */
    /***************************************************/
    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->qFormations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getStitre(): ?string
    {
        return $this->stitre;
    }

    public function setStitre(string $stitre): self
    {
        $this->stitre = $stitre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getTheme(): ?theme
    {
        return $this->theme;
    }

    public function setTheme(?theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->contains($module)) {
            $this->modules->removeElement($module);
        }

        return $this;
    }

    /**
     * @return Collection|QFormation[]
     */
    public function getQFormations(): Collection
    {
        return $this->qFormations;
    }

    public function addQFormation(QFormation $qFormation): self
    {
        if (!$this->qFormations->contains($qFormation)) {
            $this->qFormations[] = $qFormation;
            $qFormation->setFormation($this);
        }

        return $this;
    }

    public function removeQFormation(QFormation $qFormation): self
    {
        if ($this->qFormations->contains($qFormation)) {
            $this->qFormations->removeElement($qFormation);
            // set the owning side to null (unless already changed)
            if ($qFormation->getFormation() === $this) {
                $qFormation->setFormation(null);
            }
        }

        return $this;
    }
}
