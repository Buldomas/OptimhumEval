<?php

namespace App\Entity;

use App\Entity\Formation;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 * @ORM\HasLifecycleCallbacks
 *  UniqueEntity(
 *  fields={"titre"},
 *  message="Il y a déjà un thème avec ce titre !"
 * )
 */
class Module
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
     * @Assert\Length(min="3", minMessage="Le titre doit faire au moins {{ min }} caractères !")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min="25", minMessage="La description doit faire au moins {{ min}} caractères !")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="10", minMessage="Le sous-titre doit faire au moins {{ min }} caractères !")
     */
    private $stitre;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, mappedBy="modules")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=QModule::class, mappedBy="module_id", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $qModules;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->qModules = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getStitre(): ?string
    {
        return $this->stitre;
    }

    public function setStitre(string $stitre): self
    {
        $this->stitre = $stitre;

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->addModule($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            $formation->removeModule($this);
        }

        return $this;
    }

    /**
     * @return Collection|QModule[]
     */
    public function getQModules(): Collection
    {
        return $this->qModules;
    }

    public function addQModule(QModule $qModule): self
    {
        if (!$this->qModules->contains($qModule)) {
            $this->qModules[] = $qModule;
            $qModule->setModuleId($this);
        }

        return $this;
    }

    public function removeQModule(QModule $qModule): self
    {
        if ($this->qModules->contains($qModule)) {
            $this->qModules->removeElement($qModule);
            // set the owning side to null (unless already changed)
            if ($qModule->getModuleId() === $this) {
                $qModule->setModuleId(null);
            }
        }

        return $this;
    }
}
