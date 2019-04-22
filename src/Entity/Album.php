<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
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
    private $albumId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $decsription;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="albums")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlbumId(): ?string
    {
        return $this->albumId;
    }

    public function setAlbumId(string $albumId): self
    {
        $this->albumId = $albumId;

        return $this;
    }

    public function getDecsription(): ?string
    {
        return $this->decsription;
    }

    public function setDecsription(?string $decsription): self
    {
        $this->decsription = $decsription;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
        }

        return $this;
    }
}
