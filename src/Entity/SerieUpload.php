<?php

namespace App\Entity;

use App\Repository\SerieUploadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieUploadRepository::class)]
class SerieUpload
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Serie::class, inversedBy: 'serieUploads')]
    #[ORM\JoinColumn(nullable: false)]

    private $serie;

    #[ORM\ManyToOne(targetEntity: Uploads::class, inversedBy: 'serieUploads')]
    #[ORM\JoinColumn(nullable: false)]
    private $upload;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getUpload(): ?Uploads
    {
        return $this->upload;
    }

    public function setUpload(?Uploads $upload): self
    {
        $this->upload = $upload;

        return $this;
    }
}
