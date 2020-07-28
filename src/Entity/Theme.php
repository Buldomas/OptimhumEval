<?php

namespace App\Entity;

use App\Entity\Formation;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"titre"},
 *  message="Il y a déjà un thème avec ce titre !"
 * )
 */
class Theme
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
     * @Assert\Length(min="5", minMessage="Le titre doit faire au moins 5 caractères !")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min="25", minMessage="La description doit faire au moins 25 caractères !")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="10", minMessage="Le sous-titre doit faire au moins 10 caractères !")
     */
    private $stitre;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="theme")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=QTheme::class, mappedBy="theme")
     * @Assert\Valid()
     */
    private $questions;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->questions = new ArrayCollection();
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
    public function getThemeFormations(): Collection
    {
        return $this->formations;
    }

    public function addThemeFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setTheme($this);
        }
        return $this;
    }

    public function removeThemeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            // set the owning side to null (unless already changed)
            if ($formation->getTheme() === $this) {
                $formation->setTheme(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|QTheme[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(QTheme $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setTheme($this);
        }

        return $this;
    }

    public function removeQuestion(QTheme $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getTheme() === $this) {
                $question->setTheme(null);
            }
        }

        return $this;
    }
}
