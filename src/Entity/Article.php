<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

// #[ORM\Entity] dit à Doctrine : "cette classe = une table en BDD"
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    // Colonne "id" : clé primaire auto-incrémentée
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Colonne "titre" : texte, obligatoire
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    // Colonne "contenu" : long texte
    #[ORM\Column(type: 'text')]
    private ?string $contenu = null;

    // Colonne "created_at" : date de création
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    // ===== GETTERS & SETTERS =====
    // Doctrine utilise ces méthodes pour lire/écrire les données

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}