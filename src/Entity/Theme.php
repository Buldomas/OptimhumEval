<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ThemeRepository;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 * @ORM\HasLifecycleCallbacks
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
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stitre;

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
}
