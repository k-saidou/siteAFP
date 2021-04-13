<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentairesRepository::class)
 */
class Commentaires
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="commentaires")
     */
    private $retourcom;

    /**
     * @ORM\ManyToOne(targetEntity=Actualites::class, inversedBy="commentaires")
     */
    private $actu;


    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getRetourcom(): ?Users
    {
        return $this->retourcom;
    }

    public function setRetourcom(?Users $retourcom): self
    {
        $this->retourcom = $retourcom;

        return $this;
    }

    public function getActu(): ?Actualites
    {
        return $this->actu;
    }

    public function setActu(?Actualites $actu): self
    {
        $this->actu = $actu;

        return $this;
    }



}
